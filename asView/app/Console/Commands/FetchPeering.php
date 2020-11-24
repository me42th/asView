<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FetchPeering extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:peering {--asn} {--ix} {--ixasn}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve PeeringDB Data';

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
     * @return int
     */
    public function handle()
    {
        $this->info('        =/\                 /\=');
        $this->info('        / \`._   (\_/)   _.`/ |_`');
        $this->info('       / .``._`--(o.o)--`_.``. |_`');
        $this->info('      /.` _/ |``=/ " \=``| \_ `. |-_`');
        $this->info('     /` .` `\;-,`\___/`,-;/` `. ` |-_`');
        $this->info('    /.-`ASVIEW `\(-V-)/`       `-.|_-_`.');
        $this->info('    `            "   "');
        $this->info('FETCH PEERING DB DATA');

        $asnFlag = $this->option('asn');
        $ixFlag = $this->option('ix');
        $netixlanFlag = $this->option('ixasn');

        $count = 0;
        if($asnFlag){
            $count++;
        }

        if($ixFlag){
            $count++;
        }

        if($netixlanFlag){
            $count++;
        }
        $peer = new \App\Http\Controllers\AsnController;
        $bar = $this->output->createProgressBar($count);
        $bar->start();
        if($asnFlag){
           $peer->fetchAsn();
            $bar->advance();
        }

        if($netixlanFlag){
        $peer->fetchNetIxLan();
        $bar->advance();
        }

        if($ixFlag){
            $peer->fetchIx();
            $bar->advance();
        }
        $bar->finish();
        if($asnFlag){
            $this->newLine(1);
            $this->info('PERSIST ASN');
            $bar = $this->output->createProgressBar(count($peer->asn));
            $bar->start();
            foreach($peer->asn as $asn){
                $bar->advance();
                $peer->index($asn);
            }
            $bar->finish();
        }
        if($netixlanFlag){
            $this->newLine(1);
            $this->info('PERSIST IX_ASN');

            $bar = $this->output->createProgressBar(count($peer->net_ix_lan));
            $bar->start();
            foreach($peer->net_ix_lan as $net_ix_lan){
                $bar->advance();
                $peer->store($net_ix_lan);
            }
            $bar->finish();
        }
        if($ixFlag){
            $this->newLine(1);

            $this->info('PERSIST IX');

            $bar = $this->output->createProgressBar(count($peer->ix));
            $bar->start();
            foreach($peer->ix as $ix){
                $bar->advance();
                $peer->update($ix);
            }
            $bar->finish();
        }
        $this->newLine(1);
    }
}
