<?php

namespace App\Http\Controllers\Vulnerabilities;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * A06: Vulnerable and Outdated Components
 * 
 * This controller provides information about managing
 * vulnerable and outdated components in Laravel applications.
 */
class A06Controller extends Controller
{
    /**
     * Show information about vulnerable components
     * 
     * Unlike other vulnerabilities, this one is about
     * dependency management rather than code demonstration.
     */
    public function index()
    {
        $composerJson = null;
        $composerLock = null;

        // Read composer.json if it exists
        $composerJsonPath = base_path('composer.json');
        if (file_exists($composerJsonPath)) {
            $composerJson = json_decode(file_get_contents($composerJsonPath), true);
        }

        // Get installed package versions from composer.lock
        $composerLockPath = base_path('composer.lock');
        if (file_exists($composerLockPath)) {
            $lockData = json_decode(file_get_contents($composerLockPath), true);
            $composerLock = collect($lockData['packages'] ?? [])
                ->map(fn($pkg) => [
                    'name' => $pkg['name'],
                    'version' => $pkg['version'],
                    'description' => $pkg['description'] ?? 'N/A',
                ])
                ->take(20);
        }

        $securityTools = [
            [
                'name' => 'Composer Audit',
                'command' => 'composer audit',
                'description' => 'Built-in Composer command to check for known security vulnerabilities in dependencies.',
                'type' => 'CLI',
            ],
            [
                'name' => 'Snyk',
                'command' => 'snyk test',
                'description' => 'Comprehensive vulnerability scanner that integrates with CI/CD pipelines.',
                'type' => 'CLI/SaaS',
            ],
            [
                'name' => 'Dependabot',
                'command' => 'GitHub Integration',
                'description' => 'Automated dependency updates and security alerts on GitHub.',
                'type' => 'GitHub',
            ],
            [
                'name' => 'OWASP Dependency-Check',
                'command' => 'dependency-check --scan .',
                'description' => 'Open source tool that identifies project dependencies and checks for known vulnerabilities.',
                'type' => 'CLI',
            ],
            [
                'name' => 'Roave Security Advisories',
                'command' => 'composer require --dev roave/security-advisories:dev-latest',
                'description' => 'Composer package that prevents installation of packages with known vulnerabilities.',
                'type' => 'Composer',
            ],
        ];

        $bestPractices = [
            'Regularly run `composer audit` to check for vulnerabilities',
            'Keep Laravel and all packages up to date',
            'Subscribe to Laravel security announcements',
            'Use semantic versioning constraints wisely (^ vs ~)',
            'Review changelogs before updating major versions',
            'Test thoroughly after updating dependencies',
            'Use a lock file (composer.lock) in version control',
            'Set up automated dependency scanning in CI/CD',
            'Monitor security advisories for your dependencies',
            'Have a process for emergency security patches',
        ];

        return view('vulnerabilities.a06.index', [
            'composerJson' => $composerJson,
            'packages' => $composerLock,
            'securityTools' => $securityTools,
            'bestPractices' => $bestPractices,
            'laravelVersion' => app()->version(),
            'phpVersion' => PHP_VERSION,
        ]);
    }
}
