<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Prism\Prism\Prism;
use App\Services\PrismClient;

class AIService
{
    protected $client;

    public function __construct(Prism $client)
    {
        $this->client = $client;
    }

  
    public function chat(string $userMessage): string
    {
       
        $databaseResults = $this->searchInDatabase($userMessage);

      
        $storageResults = $this->searchInStorage($userMessage);

      
        $prompt = $this->createPrompt($userMessage, $databaseResults, $storageResults);

      
        return $this->askAI($prompt);
    }

   
    private function searchInDatabase(string $userMessage)
    {
      
        $results = DB::table('unidades')
            ->where('DescripcionUnidades', 'LIKE', "%$userMessage%")
            ->get();

      
        return $results;
    }

  
    private function searchInStorage(string $userMessage)
    {
       
        $files = Storage::files('documentos'); 
        
        $content = [];
        foreach ($files as $file) {
            $fileContent = Storage::get($file); 
            if (strpos($fileContent, $userMessage) !== false) {
                $content[] = $fileContent;  
            }
        }

        return $content;
    }

  
    private function createPrompt(string $userMessage, $databaseResults, $storageResults)
    {
        $databaseContent = $this->formatDatabaseResults($databaseResults);
        $storageContent = $this->formatStorageResults($storageResults);

        $prompt = "Usuario pregunta: '$userMessage'.\n\n";
        $prompt .= "Estos son los datos encontrados en la base de datos:\n";
        $prompt .= $databaseContent;
        $prompt .= "\n\nY estos son los archivos relacionados:\n";
        $prompt .= $storageContent;

        $prompt .= "\n\nCon base en esta información, por favor proporciona una respuesta útil y sugerencias adicionales si es posible.";

        return $prompt;
    }

   
    private function formatDatabaseResults($results)
    {
        if ($results->isEmpty()) {
            return "No se encontraron resultados en la base de datos.";
        }

        $formattedResults = "";
        foreach ($results as $result) {
            $formattedResults .= "Proyecto: {$result->nombre}, Descripción: {$result->descripcion}\n";
        }

        return $formattedResults;
    }

   
    private function formatStorageResults($results)
    {
        if (empty($results)) {
            return "No se encontraron archivos relacionados.";
        }

        $formattedResults = "";
        foreach ($results as $content) {
            $formattedResults .= "Contenido encontrado: " . substr($content, 0, 200) . "... (ver más).\n";
        }

        return $formattedResults;
    }

  
    private function askAI(string $prompt)
    {

        //dd($this->client->text());

       /* try {
            $response = $this->client->text()
                ->model('gpt-3.5-turbo') 
                ->createChatCompletion([
                    'messages' => [
                        ['role' => 'system', 'content' => 'Eres un asistente que ayuda a buscar información interna en documentos y base de datos.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ]);

            logger()->info('Prism Response:', $response->toArray());
            return $response->toArray()['choices'][0]['message']['content'] ?? 'No se pudo procesar tu solicitud.';
        } catch (\Throwable $e) {

            dd($this->client->text(),'aqui');

           // logger()->error('Prism Error: ' . $e->getMessage());
            //logger()->error('Prism Stack Trace: ' . $e->getTraceAsString());
            //return 'Error en la conexión con la IA Service.';

            logger()->error('Prism Error: ' . $e->getMessage());
            logger()->error('Prism Stack Trace: ' . $e->getTraceAsString());
        
            // OPCIONAL: Mostrar el error directamente mientras haces debugging
            return 'Error de IA: ' . $e->getMessage();
           
        }*/

        try {
            $response = Prism::text()
                ->chat()
                ->model('gpt-3.5-turbo') 
                ->create([
                    'messages' => $prompt,
                ]);

            return $response->toArray()['choices'][0]['message']['content'] ?? 'No hubo respuesta del modelo.';
        } catch (\Throwable $e) {
            logger()->error('Prism Error: ' . $e->getMessage());
            return 'Error en la conexión a la IA service22: ' . $e->getMessage();
        }

        

    }

    
}

