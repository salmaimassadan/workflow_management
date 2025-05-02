<?php
namespace App\Services;

use App\Models\CourrierTemplate;
use Illuminate\Support\Facades\Auth;

class ResponseGeneratorService
{
    public function generateResponse($courrier)
{
    // Trouver le modèle de réponse avec des placeholders pour 'subject', 'content', et 'user_name'
    $template = CourrierTemplate::where('content', 'LIKE', '%{subject}%')->first();

    // Assurer que le modèle existe
    if ($template) {
        // Obtenir l'utilisateur connecté via le guard approprié
        $userName = Auth::guard('employee')->user()->email; // Assurez-vous que `name` est un attribut de `Employee`

        // Remplacer les placeholders dans le contenu du modèle
        $responseContent = str_replace(
            ['{subject}', '{content}', '{user_name}'],
            [$courrier->subject, $courrier->content, $userName],
            $template->content
        );

        return $responseContent;
    }

    // Contenu par défaut si aucun modèle n'est trouvé
    return "Merci pour votre courrier concernant {$courrier->subject}. Nous avons bien reçu votre message et le contenu suivant :
{$courrier->content}

Nous vous contacterons sous peu.

Cordialement,
L'Équipe.";
}

}
