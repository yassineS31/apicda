<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\Account;
use App\Repository\AccountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


#[AsCommand(
    name: 'create-user',
    description: 'Commande pour ajouter un utilisateur en BDD',
)]
class CreateUserCommand extends Command
{
    public function __construct(
        private readonly AccountRepository $accountRepository,
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $hasher
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this

            // configure an argument
            ->addArgument('firstname', InputArgument::REQUIRED, 'Prénon de l\'utilisateur')
            ->addArgument('lastname', InputArgument::REQUIRED, 'Nom de l\'utilisateur')
            ->addArgument('email', InputArgument::REQUIRED, 'Email de l\'utilisateur')
            ->addArgument('password', InputArgument::REQUIRED, 'Email de l\'utilisateur')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('firstname');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }
        $io->writeln('Lastname: '.$input->getArgument('lastname'));
        $io->writeln('Firstname: '.$input->getArgument('firstname'));
        $io->writeln('Email: '.$input->getArgument('email'));
        $io->writeln('Password: '.$input->getArgument('password'));
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
