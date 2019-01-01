<?php

declare(strict_types=1);

namespace PhpVersions\PHParse;

use Naneau\SemVer\Parser as SemVerParser;
use Naneau\SemVer\Version;

class Info
{
    /** @var string */
    private $version;

    /** @var array */
    private $infoItems;

    public function __construct(string $version, array $infoItems = [])
    {
        $this->version = $version;
        $this->infoItems = $infoItems;
    }

    public function phpVersion() : string
    {
        return $this->version;
    }

    public function phpSemanticVersion() : Version
    {
        return SemVerParser::parse(
            $this->normalizeSemVerSuffix(
                $this->stripCustomBuilds($this->version)
            )
        );
    }

    /**
     * PHP releases use SemVer numbers, but the format is a bit out of whack with
     * the usual vx.y.z-beta1 style SemVer parser expects.
     */
    private function normalizeSemVerSuffix(string $version): string
    {
        foreach (['alpha', 'beta', 'RC'] as $suffix) {
            if (stripos($version, $suffix) !== false) {
                return str_replace($suffix, "-{$suffix}", $version);
            }
        }
        // Get rid of any remaining build nonsense
        return $this->stripLeftOf($version, '-');
    }

    private function stripCustomBuilds(string $version): string
    {
        $version = $this->stripLeftOf($version, '~');
        $version = $this->stripLeftOf($version, '+');
        return $version;
    }

    private function stripLeftOf(string $subject, string $needle): string
    {

        return strpos($subject, $needle) === false
          ? $subject
          : substr($subject, 0, strpos($subject, $needle));
    }
}
