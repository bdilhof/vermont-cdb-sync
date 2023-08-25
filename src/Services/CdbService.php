<?php

namespace VermontDevelopment\CdbSync\Services;

use Facades\VermontDevelopment\CdbSync\Repositories\AgeGroupRepository;
use Facades\VermontDevelopment\CdbSync\Repositories\CentreRepository;
use Facades\VermontDevelopment\CdbSync\Repositories\ColorRepository;
use Facades\VermontDevelopment\CdbSync\Repositories\CountryRepository;
use Facades\VermontDevelopment\CdbSync\Repositories\CurrencyRepository;
use Facades\VermontDevelopment\CdbSync\Repositories\DiagramRepository;
use Facades\VermontDevelopment\CdbSync\Repositories\InventoryGroupRepository;
use Facades\VermontDevelopment\CdbSync\Repositories\OrderGroupRepository;
use Facades\VermontDevelopment\CdbSync\Repositories\SeasonRepository;
use Facades\VermontDevelopment\CdbSync\Repositories\SizeRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CdbService
{
    protected string $url;

    protected string $key;

    protected string $secret;

    protected bool $sslVerify;

    public function __construct()
    {
        $this->url       = config('cdb-sync.connection.url');
        $this->key       = config('cdb-sync.connection.key');
        $this->secret    = config('cdb-sync.connection.secret');
        $this->sslVerify = config('cdb-sync.connection.ssl_verify');
    }

    public function SyncAgeGroups()
    {
        $url  = "{$this->url}/age-groups/v1";
        $data = $this->getResponseFromApi($url);

        foreach ($data as $item) {
            AgeGroupRepository::updateOrCreate([
                'id' => $item['id'],
            ], [
                'name'        => $item['name'],
                'description' => $item['description'],
                'age_from'    => $item['age_from'],
                'age_to'      => $item['age_to'],
                'is_active'   => $item['is_active'],
            ]);
        }
    }

    private function getResponseFromApi($url)
    {
        $response = Http::withBasicAuth($this->key, $this->secret)
            ->withOptions(['verify' => $this->sslVerify])
            ->get($url);

        return $response->json()['data'];
    }

    public function SyncSizes()
    {
        $url  = "{$this->url}/sizes/v1";
        $data = $this->getResponseFromApi($url);

        foreach ($data as $item) {
            SizeRepository::updateOrCreate([
                'id' => $item['id'],
            ], [
                'eso_id'      => $item['eso_id'],
                'code'        => $item['code'],
                'size_weight' => $item['size_weight'],
                'is_active'   => $item['is_active'],
            ]);
        }
    }

    public function SyncSeasons()
    {
        $url  = "{$this->url}/seasons/v1";
        $data = $this->getResponseFromApi($url);

        foreach ($data as $item) {
            SeasonRepository::updateOrCreate([
                'id' => $item['id'],
            ], [
                'eso_id'        => $item['eso_id'],
                'code'          => $item['code'],
                'name'          => $item['name'],
                'season_number' => $item['season_number'],
            ]);
        }
    }

    public function SyncOrderGroups()
    {
        $url  = "{$this->url}/order-groups/v1";
        $data = $this->getResponseFromApi($url);

        foreach ($data as $item) {
            OrderGroupRepository::updateOrCreate([
                'id' => $item['id'],
            ], [
                'name'               => $item['name'],
                'name_sk_hu'         => $item['name_sk_hu'],
                'description'        => $item['description'],
                'eso_id'             => $item['eso_id'],
                'diagram_id'         => $item['diagram_id'],
                'inventory_group_id' => $item['inventory_group_id'],
                'is_active'          => $item['is_active'],
            ]);
        }
    }

    public function SyncCentres()
    {
        $url      = "{$this->url}/centres/v1?page=1&per_page=40&columns=id,code,name,active,address_id&relations=itdata:centre_id,publicip;address.city;contact:centre_id,email";
        $response = $this->getResponse($url);

        while ($response->links->next !== null) {
            $response = $this->getResponse($response->links->next);
        }
    }

    protected function getResponse($url)
    {
        $response = Http::withBasicAuth($this->key, $this->secret)
            ->withOptions(['verify' => $this->sslVerify])
            ->get($url)
            ->object();

        $data = $response->data;

        if (count($data)) {
            foreach ($data as $centre) {
                CentreRepository::updateOrCreate([
                    'cdb_id' => $centre->id
                ], [
                    'name'       => $centre->name,
                    'code'       => $centre->code,
                    'street'     => $centre->address->street,
                    'number'     => $centre->address->number,
                    'zip'        => $centre->address->zip,
                    'city'       => $centre->address->city->name,
                    'country_id' => $centre->address->country_id,
                    'email'      => $centre->contact->email ?? '',
                    'public_ip'  => ($centre->itdata->publicip ? implode(', ', $centre->itdata->publicip) : null),
                    'is_active'  => $centre->active,
                ]);
            }
        }

        return $response;
    }

    public function SyncInventoryGroups()
    {
        $url  = "{$this->url}/inventory-groups/v1";
        $data = $this->getResponseFromApi($url);

        foreach ($data as $item) {
            InventoryGroupRepository::updateOrCreate([
                'id' => $item['id'],
            ], [
                'eso_id'      => $item['eso_id'],
                'name'        => $item['name'],
                'description' => $item['description'],
                'is_active'   => $item['is_active'],
            ]);
        }
    }

    public function SyncDiagrams()
    {
        $url  = "{$this->url}/diagrams/v1";
        $data = $this->getResponseFromApi($url);

        foreach ($data as $item) {
            $file         = file_get_contents($item['image']);
            $randomString = Str::random(40);
            $filepath     = 'cdb-sync/diagrams/';
            $filename     = $filepath.md5('filename`'.time().$randomString)
                .'.jpg';
            $imageIsSaved = Storage::disk('public')->put($filename, $file);

            DiagramRepository::updateOrCreate([
                'id' => $item['id'],
            ], [
                'code'      => $item['code'],
                'name'      => $item['name'],
                'image'     => $filename,
                'is_active' => $item['is_active'],
            ]);
        }
    }

    public function SyncCurrencies()
    {
        $url  = "{$this->url}/currencies/v1";
        $data = $this->getResponseFromApi($url);

        foreach ($data as $item) {
            CurrencyRepository::updateOrCreate([
                'id' => $item['id'],
            ], [
                'html_symbol' => $item['html_symbol'],
                'code'        => $item['code'],
                'name'        => $item['name'],
                'symbol'      => $item['symbol'],
                'is_active'   => $item['is_active'],
            ]);
        }
    }

    public function SyncColors()
    {
        $url  = "{$this->url}/colors/v1";
        $data = $this->getResponseFromApi($url);

        foreach ($data as $item) {
            ColorRepository::updateOrCreate([
                'id' => $item['id'],
            ], [
                'eso_id'    => $item['eso_id'],
                'name'      => $item['name'],
                'is_active' => $item['is_active'],
            ]);
        }
    }

    public function SyncCountries()
    {
        $url  = "{$this->url}/countries/v1";
        $data = $this->getResponseFromApi($url);

        foreach ($data as $item) {
            CountryRepository::updateOrCreate([
                'id' => $item['id'],
            ], [
                'code'    => $item['code'],
                'name'      => $item['name'],
                'is_active' => $item['active'],
            ]);
        }
    }
}

