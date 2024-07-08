<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Bunny\Storage\Client;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{

    public function __construct(Client $bunnyClient)
    {
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|integer',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:10048',
        ]);

        $carId = $request->input('car_id');
        $photos = $request->file('photos');
        $photoUrls = [];

        foreach ($photos as $photo) {
            $fileName = uniqid() . '.' . $photo->getClientOriginalExtension();
            $remotePath = "desafio/cars/$carId/$fileName";

            $repo_url = env('BUNNYCDN_URL');
            
            $storageZone = env('BUNNYCDN_STORAGE_ZONE');

            $url = "https://$storageZone/$remotePath"; // Substitua com sua zona de armazenamento

            $fileContents = file_get_contents($photo->getPathname());

            $client = new GuzzleHttpClient();

            try {
                $client->request('PUT', $url, [
                    'headers' => [
                        'AccessKey' => env('BUNNYCDN_API_KEY'), // Substitua com sua chave de API do BunnyCDN
                        'Content-Type' => 'application/octet-stream',
                    ],
                    'body' => $fileContents,
                    'verify' => false, // Desativa a verificação do certificado SSL
                ]);

                $photoUrls[] = "$repo_url/cars/$carId/$fileName";
                 // Salvar no banco de dados
                 $photoModel = new Photo();
                 $photoModel->car_id = $carId;
                 $photoModel->photo_url = "$repo_url/cars/$carId/$fileName";
                 $photoModel->save();

            } catch (\Exception $e) {
                // Capturar exceções do GuzzleHttp
                $photoUrls[] = "Erro ao enviar arquivo: " . $e->getMessage();
            }
        }

        return response()->json(['Urls' => $photoUrls], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
