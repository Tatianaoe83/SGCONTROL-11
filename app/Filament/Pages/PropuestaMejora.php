<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactoGeneralMail;
use Filament\Notifications\Notification;

class PropuestaMejora extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?string $navigationLabel = 'Propuesta de Mejora';
    protected static ?string $title = 'Propuesta de Mejora';
    protected static string $view = 'filament.pages.propuesta-mejora';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('nombre')
                ->label('Tu nombre')
                ->required()
                ->maxLength(255),
            
            Forms\Components\TextInput::make('email')
                ->label('Tu correo')
                ->email()
                ->required(),
            
            Forms\Components\Textarea::make('mensaje')
                ->label('Tu propuesta de mejora')
                ->rows(6)
                ->required(),
        ];
    }

    protected function getFormModel(): string
    {
        return static::class;
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    public function submit(): void
    {
        $datos = $this->form->getState();

        try {
            Mail::to('tordonez@proser.com.mx')->send(new ContactoGeneralMail($datos));

            Notification::make()
                ->title('¡Propuesta enviada!')
                ->body('Gracias por tu propuesta de mejora.')
                ->success()
                ->send();

            $this->form->fill(); // Limpia el formulario
        } catch (\Throwable $e) {
            Notification::make()
                ->title('Error al enviar')
                ->body('No se pudo enviar tu propuesta. Inténtalo más tarde.')
                ->danger()
                ->send();

            \Log::error('Error al enviar propuesta de mejora: ' . $e->getMessage());
        }
    }
}
