<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class GithubWebhooksController extends Controller
{
    public function deploy(Request $request)
    {
        $this->validateGithubWebhook(config('app.github_secret'), $request);

        $process = new Process(['sh /var/www/projekata/deploy.sh']);
        $process->run();
    }

    protected function validateGithubWebhook($knownToken, Request $request)
    {
        if(($signature = $request->headers->get('X-Hub-Signature')) == null)
        {
            die();
        }

        $signatureParts = explode('=', $signature);

        if(count($signatureParts) != 2)
        {
            die();
        }

        $known_signature = hash_hmac('sha1', $request->getContent(), $knownToken);

        if(!hash_equals($known_signature, $signatureParts[1]))
        {
            die();
        }
    }
}
