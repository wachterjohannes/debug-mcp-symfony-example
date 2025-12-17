<?php

namespace App\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:initialize-logs',
    description: 'Initialize log files by triggering logs at different levels',
)]
class InitializeLogsCommand extends Command
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Initializing Log Files');

        // Log at different levels to initialize the log files
        $this->logger->debug('Debug log entry - detailed debugging information', [
            'timestamp' => time(),
            'context' => 'initialization',
        ]);

        $this->logger->info('Info log entry - informational message', [
            'status' => 'initializing',
            'user' => 'system',
        ]);

        $this->logger->notice('Notice log entry - normal but significant event', [
            'event' => 'log_initialization',
            'component' => 'console',
        ]);

        $this->logger->warning('Warning log entry - warning message for testing', [
            'severity' => 'low',
            'test_mode' => true,
        ]);

        $this->logger->error('Error log entry - test error message', [
            'error_code' => 'TEST_001',
            'recoverable' => true,
        ]);

        $this->logger->critical('Critical log entry - test critical condition', [
            'system_component' => 'test',
            'requires_attention' => false,
        ]);

        $this->logger->alert('Alert log entry - test alert condition', [
            'alert_type' => 'test',
            'action_required' => false,
        ]);

        $this->logger->emergency('Emergency log entry - test emergency', [
            'emergency_type' => 'test',
            'system_status' => 'stable',
        ]);

        $io->success([
            'Log files initialized successfully!',
            'Created log entries at all levels: DEBUG, INFO, NOTICE, WARNING, ERROR, CRITICAL, ALERT, EMERGENCY',
        ]);

        $io->note('Check the log files in var/log/ directory');

        return Command::SUCCESS;
    }
}
