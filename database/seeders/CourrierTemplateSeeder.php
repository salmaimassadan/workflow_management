<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourrierTemplateSeeder extends Seeder
{
    public function run()
    {
        DB::table('courrier_templates')->insert([
            'title' => 'Réponse Générale',
            'content' => 'Bonjour,

Bonjour,

Merci pour votre courrier concernant {subject}. Nous avons bien reçu votre message et le contenu suivant :
{content}

Nous vous contacterons sous peu.

Cordialement,
{user_name}',
        ]);
    }
}
