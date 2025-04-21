<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Empleado; // O el modelo que uses

class ChatBotComponent extends Component
{
    public $userMessage = '';
    public $messages = [];

    public function sendMessage()
    {
        $this->messages[] = ['role' => 'user', 'text' => $this->userMessage];

        // Simulación de lógica inteligente (ejemplo simple)
        $response = $this->processMessage($this->userMessage);
        
        $this->messages[] = ['role' => 'bot', 'text' => $response];

        $this->userMessage = '';
    }

    public function processMessage($msg)
    {
        // Ejemplo: buscar empleados por nombre
        if (str_contains(strtolower($msg), 'buscar empleado')) {
            $nombre = str_replace('buscar empleado ', '', strtolower($msg));
            $resultados = Empleado::where('nombre', 'like', "%$nombre%")->pluck('nombre');

            return $resultados->isNotEmpty()
                ? 'Resultados: ' . $resultados->join(', ')
                : 'No se encontró ningún empleado con ese nombre.';
        }

        return 'No entendí tu mensaje. ¿Puedes reformularlo?';
    }

    public function render()
    {
        return view('livewire.chat-bot');
    }
}
