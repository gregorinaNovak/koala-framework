<?php
class Kwf_Assets_ResponsiveEl_Provider extends Kwf_Assets_Provider_Abstract
{
    public function getDependenciesForDependency(Kwf_Assets_Dependency_Abstract $dependency)
    {
        if ($dependency->getMimeType() == 'text/css') {
            $contents = $dependency->getContents('en');
            if (preg_match_all('#([^}{]*){[^}]*kwf-responsive-el-gt:\s*([0-9]+)#', $contents, $m)) {
                $selectors = array();
                foreach (array_keys($m[1]) as $k) {
                    if (!isset($selectors[$m[1][$k]])) $selectors[$m[1][$k]] = array();
                    $selectors[$m[1][$k]][] = $m[2][$k];
                }
                foreach ($selectors as $selector=>$breakpoints) {
                    $d = new Kwf_Assets_ResponsiveEl_JsDependency($selector, $breakpoints);
                    $d->addDependency(Kwf_Assets_Dependency_Abstract::DEPENDENCY_TYPE_REQUIRES, $this->_providerList->findDependency('KwfResponsiveEl'));
                    $ret[] = $d;
                }
                return array(
                    Kwf_Assets_Dependency_Abstract::DEPENDENCY_TYPE_REQUIRES => $ret
                );
            }
        }
        return array();
    }

    public function getDependency($dependencyName)
    {
        return null;
    }
}