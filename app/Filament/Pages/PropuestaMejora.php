<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;

class PropuestaMejora extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';
    protected static string $view = 'filament.pages.propuesta-mejora';
    protected static ?string $title = 'Propuesta de mejora';
    protected static ?string $navigationGroup = 'Soporte';
    protected static bool $shouldRegisterNavigation = false; 

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Textarea::make('message')
                    ->label('Tu propuesta')
                    ->required()
                    ->rows(5),
            ])
            ->statePath('data');
    }

    public function submit()
    {
        try {
            Mail::raw($this->data['message'], function ($message) {
                $message->to('tordonez@proser.com.mx')->subject('Propuesta de mejora');
            });

            Notification::make()
                ->title('¡Propuesta enviada!')
                ->success()
                ->send();

            $this->form->fill();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error al enviar propuesta')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
