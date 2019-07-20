<?php

namespace App\Controller;

use App\Helper\MeetupHelper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    /**
     * @Route("/hello.{_format}",
     *     defaults={"_format": "html"},
     *     name="hello"
     * )
     *
     * @return Response
     */
    public function helloAction(Request $request, MeetupHelper $helper): Response
    {
        $name = $request->get('name', 'Bali');
        $participants = $helper->getNextMeetupParticipantCount();

        if ('json' === $request->getRequestFormat()) {
            return new JsonResponse([
                'hello' => $name,
                'participants' => $participants,
            ]);
        }

        return new Response(
            '<html>
                <body>
                    <h1>Hello, '.htmlspecialchars($name).'!</h1>
                    <p>Wow, '.$participants.' people are coming!</p>
                </body>
            </html>'
        );
    }
}
