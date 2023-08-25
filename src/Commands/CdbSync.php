<?php

namespace VermontDevelopment\CdbSync\Commands;

use Illuminate\Console\Command;

class CdbSync extends Command
{
    protected $signature = 'cdb:sync {table}';

    protected $description = 'Command to sychronize Vermont Centres from CDB into child projects';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $table = $this->argument('table');

        switch ($table) {
            case 'centres':
                \CdbSync::SyncCentres();
                $this->line("Centres sucesfully synchronized");
                break;
            case 'order-groups':
                \CdbSync::SyncOrderGroups();
                $this->line("Order groups sucesfully synchronized");
                break;
            case 'inventory-groups':
                \CdbSync::SyncInventoryGroups();
                $this->line("Inventory groups sucesfully synchronized");
                break;
            case 'age-groups':
                \CdbSync::SyncAgeGroups();
                $this->line("Age groups sucesfully synchronized");
                break;
            case 'diagrams':
                \CdbSync::SyncDiagrams();
                $this->line("Diagrams sucesfully synchronized");
                break;
            case 'currencies':
                \CdbSync::SyncCurrencies();
                $this->line("Currencies sucesfully synchronized");
                break;
            case 'colors':
                \CdbSync::SyncColors();
                $this->line("Colors sucesfully synchronized");
                break;
            case 'sizes':
                \CdbSync::SyncSizes();
                $this->line("Sizes sucesfully synchronized");
                break;
            case 'seasons':
                \CdbSync::SyncSeasons();
                $this->line("Seasons sucesfully synchronized");
                break;
            case 'countries':
                \CdbSync::SyncCountries();
                $this->line("Countries sucesfully synchronized");
                break;


            default:
                $this->error("${table} is not valid argument for this command.");
                $this->newLine();
                $this->line("Please provide one of following options:");
                $this->line("- age-groups");
                $this->line("- centres");
                $this->line("- colors");
                $this->line("- countries");
                $this->line("- currencies");
                $this->line("- diagrams");
                $this->line("- inventory-groups");
                $this->line("- order-groups");
                $this->line("- seasons");
                $this->line("- sizes");
                $this->newLine();
                break;
        }
    }

    public function failed()
    {
        $this->error('Command failed');
    }
}
