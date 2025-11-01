<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageSelector extends Component
{
    public $currentLocale;
    
    public function mount()
    {
        $this->currentLocale = App::getLocale();
    }
    
    public function changeLocale($locale)
    {
        if (in_array($locale, ['es', 'en'])) {
            App::setLocale($locale);
            Session::put('locale', $locale);
            $this->currentLocale = $locale;
            
            // Refresh the page to apply language changes
            return $this->redirect(request()->header('Referer'), navigate: true);
        }
    }
    
    public function render()
    {
        return view('livewire.layout.language-selector');
    }
}
