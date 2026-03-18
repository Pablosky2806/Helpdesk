<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Illuminate\Console\Command;

class GenerateTokensCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:generate-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate access tokens for tickets that don\'t have one';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info(' Generando tokens para tickets sin token...');
        
        $tickets = Ticket::whereNull('token_acceso')->get();
        
        if ($tickets->isEmpty()) {
            $this->info(' Todos los tickets ya tienen token');
            return 0;
        }
        
        $count = 0;
        foreach ($tickets as $ticket) {
            $ticket->token_acceso = uniqid('tk_', true);
            $ticket->save();
            $count++;
            $this->line(" Token generado para ticket #{$ticket->id}: {$ticket->token_acceso}");
        }
        
        $this->info(" {$count} tokens generados correctamente");
        
        // Mostrar todos los tokens disponibles
        $this->line("\n URLs de acceso público:");
        Ticket::all()->each(function ($ticket) {
            $this->line(" Ticket #{$ticket->id}: http://127.0.0.1:8000/estado/{$ticket->token_acceso}");
        });
        
        return 0;
    }
}
