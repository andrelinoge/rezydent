<?php
/**
 * @author Andriy Tolstokorov
 */

class ClientScript extends CClientScript
{
    /**
     * Renders the specified core javascript library with additional param - position.
     */
    public function renderCoreScripts()
    {
        if($this->coreScripts === NULL ) {
            return;
        }

        $cssFiles=array();
        $jsFiles=array();

        // scan packages to prepare js and css for include
        foreach($this->coreScripts as $name => $package) {
            $baseUrl = $this->getPackageBaseUrl( $name );

            if(!empty($package['js']))
            {
                foreach($package['js'] as $js)
                {
                    if ( isset( $package[ 'position' ] ) )
                    {
                        $jsFiles[ $package[ 'position' ] ][ $baseUrl . '/' . $js ] = $baseUrl . '/' . $js;
                    }
                    else
                    {
                        $jsFiles[ $this->coreScriptPosition ][ $baseUrl . '/' . $js ] = $baseUrl . '/' . $js;
                    }
                }
            }

            if(!empty($package['css']))
            {
                foreach($package['css'] as $css)
                {
                    $cssFiles[ $baseUrl.'/'.$css ] = '';
                }
            }
        }

        // merge css in place
        if( $cssFiles!==array() )
        {
            foreach($this->cssFiles as $cssFile => $media)
            {
                $cssFiles[$cssFile]=$media;
            }

            $this->cssFiles = $cssFiles;
        }

        // merge js in place
        if( $jsFiles !== array() )
        {
            foreach ( $jsFiles as $position => $files )
            {
                if( isset( $this->scriptFiles[ $position ] ) )
                {
                    if ( is_array( $this->scriptFiles[ $position ] ) )
                    {
                        // to keep order: first scripts from core/packages, then rest
                        $this->scriptFiles[ $position ] = $files + $this->scriptFiles[ $position ];
                    }
                }
                else
                {
                    $this->scriptFiles[ $position ] = $files;
                }
            }
        }

    }
}