<?php namespace Sturgeon\PHPArse;

use Naneau\SemVer\Parser as SemVerParser;

class Info
{
    public function __construct(string $version, array $infoItems = [])
    {
        $this->version = $version;
        $this->infoItems = $infoItems;
    }

    public function phpVersion()
    {
        return $this->version;
    }

    public function phpSemanticVersion()
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
        if (strpos($version, '-') === true) {
            return $version;
        }
        return str_ireplace(['alpha', 'beta', 'rc'], ['-alpha', '-beta', '-rc'], $version);
    }

    private function stripCustomBuilds(string $version): string
    {
        $fuckTildes = substr($version, strpos($version, '~'));
        return substr($version, strpos($version, '+'));
    }
}
