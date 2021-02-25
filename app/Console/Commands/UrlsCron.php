<?php

namespace App\Console\Commands;

use App\Url;
use Illuminate\Console\Command;
use Symfony\Component\HttpClient\HttpClient;

class UrlsCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verificarUrl:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar urls';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $urls = Url::all();

        if (isset($urls) && count($urls) > 0) {
            foreach ($urls as $url) {
                $client      = HttpClient::create();
                $request     = $client->request('GET', $url['url']);
                $status_code = $request->getStatusCode();
                $content     = $request->getContent();

                // Salvar o retorno no banco
                $att_url               = Url::find($url['id']);
                $att_url->status_http  = $status_code;
                $att_url->corpo_html   = utf8_encode($content);
                $att_url->data_acesso  = date('Y-m-d H:i:s'); 
                $att_url->save();
            }
        }
    }
}
