<?php


namespace App\Command;


use App\Repository\ExchangeRateRepository;
use App\Service\SaveCurrencyService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;

class ImportRateApi extends Command
{
    protected function configure()
    {
        $this
            ->setName('import-rate-api')
            ->setDescription('import-rate-api')
            ->setHelp('Import-rate-api...')

        ;
    }

    private $saveCurrencyService;
    private $exchangeRateRepository;


    /**
     * @var EntityManagerInterface
     */
    public function __construct(
        SaveCurrencyService $saveCurrencyService,
    ExchangeRateRepository $exchangeRateRepository
    )
    {
        $this->exchangeRateRepository = $exchangeRateRepository;
        $this->saveCurrencyService = $saveCurrencyService;
        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Import rate api...',

        ]);

        $this->exchangeRateRepository->deleteCurrency();

        $client = HttpClient::create();
        $thisDate = date('Y-m-d');
        $arr = array();
        for($i=0; $i<7 ;$i++)
        {
            $date = date('Y-m-d', strtotime($thisDate. " - $i day"));
            $response = $client->request('GET', 'http://nbrb.by/Services/XmlExRates.aspx?ondate='.$date);
            $content = $response->getContent();
            $dailyExRates = new \SimpleXMLElement($content);


            echo $date.PHP_EOL;

            $j = 0;
            foreach ($dailyExRates->Currency as $currency) {

                $id = (int)$currency['Id'];
                $arr[$j] = array('Id' => $id,'NumCode' => $currency->NumCode, 'CharCode' => $currency->CharCode, 'Scale' => $currency->Scale, 'Name' => $currency->Name, 'Rate' => $currency->Rate);
            $j++;
            }


            $json = json_encode($arr, JSON_UNESCAPED_UNICODE);

            var_dump($json);
            $date = new \DateTime($date);

            $this->saveCurrencyService->saveCurrency($date,$json);
        }

        $output->writeln('Import rate api completed!');
    }
}