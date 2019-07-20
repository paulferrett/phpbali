<?php

namespace App\Command;

use App\Helper\MeetupHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class HelloCommand extends Command
{
    protected static $defaultName = 'hello:world';

    /** @var MeetupHelper */
    protected $meetupHelper;

    public function __construct(MeetupHelper $meetupHelper)
    {
        parent::__construct();

        $this->meetupHelper = $meetupHelper;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);
        $style->title('Meetup Demo');

        $name = $style->ask('What\'s your name?');
        $style->text(sprintf('Hi, %s!', $name));

        $participants = $this->meetupHelper->getNextMeetupParticipantCount();
        $style->text(sprintf('Say hi to your %d new friends!', $participants));
    }
}
