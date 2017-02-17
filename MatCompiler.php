<?php
require_once("config.php");
use Leafo\ScssPhp\Compiler;
/**
* Class that manages materialize.scss
* @author yeray697
*/
class MatCompiler{

    private $makeSCSS;
    
    function __construct(){
        $this->makeSCSS = new MakeSCSS();
    }

    //Methods

    /**
    * Tries setting the primary color
    *
    * @param string $color Color to set
    *
    * @param string $tone Tone to set   
    *
    * @param boolean $updateFile Update _variables.scss after set the color (default = false)   
    *
    * @return boolean Indicates if it is valid
    */
    function setPrimaryColor($color,$tone,$updateFile = false){
        $this->makeSCSS->setPrimaryColor($color,$tone,$updateFile);
    }


    /**
    * Tries setting the secondary color
    *
    * @param string $color Color to set
    *
    * @param string $tone Tone to set   
    *
    * @param boolean $updateFile Update _variables.scss after set the color (default = false)   
    *
    * @return boolean Indicates if it is valid
    */
    function setSecondaryColor($color,$tone,$updateFile = false){
        $this->makeSCSS->setSecondaryColor($color,$tone,$updateFile);
    }


    /**
    * Tries setting the success color
    *
    * @param string $color Color to set
    *
    * @param string $tone Tone to set   
    *
    * @param boolean $updateFile Update _variables.scss after set the color (default = false)   
    *
    * @return boolean Indicates if it is valid
    */
    function setSuccessColor($color,$tone,$updateFile = false){
        $this->makeSCSS->setSuccessColor($color,$tone,$updateFile);
    }


    /**
    * Tries setting the error color
    *
    * @param string $color Color to set
    *
    * @param string $tone Tone to set   
    *
    * @param boolean $updateFile Update _variables.scss after set the color (default = false)   
    *
    * @return boolean Indicates if it is valid
    */
    function setErrorColor($color,$tone,$updateFile = false){
        $this->makeSCSS->setErrorColor($color,$tone,$updateFile);
    }

    /**
    * Set the links color
    *
    * @param string $directory Directory where materialize.css is going to be compiled
    *
    * @return void
    */
    function setLinkColor($color,$tone,$updateFile = false){
        $this->makeSCSS->setLinkColor($color,$tone,$updateFile);
    }

    

    /**
    * Compile materialize.scss into $directory/materialize.css
    *
    * @param string $directory Directory where materialize.css is going to be compiled
    *
    * @return void
    */
    function compileScss($directory, $cssFileName = "materialize.css") {
        $this->compile($directory,$cssFileName,"Expanded");
    }

    /**
    * Compile materialize.scss into $directory/materialize.css, with the same format as compileScss(), but it is tabulated if is an inner class
    *
    * @param string $directory Directory where materialize.css is going to be compiled
    *
    * @return void
    */
    function compileScssNested($directory, $cssFileName = "materialize.css"){
        $this->compile($directory,$cssFileName,"Nested");
    }

    /**
    * Compile materialize.scss into $directory/materialize.css, and it every style is shown in a line
    *
    * @param string $directory Directory where materialize.css is going to be compiled
    *
    * @return void
    */
    function compileScssCompact($directory, $cssFileName = "materialize.css") {
        $this->compile($directory,$cssFileName,"Compact");
    }

    /**
    * Compile materialize.scss into $directory/materialize.css, and the css is compressed (it KEEPS comments)
    *
    * @param string $directory Directory where materialize.css is going to be compiled
    *
    * @return void
    */
    function compileScssCompressed($directory, $cssFileName = "materialize.css") {
        $this->compile($directory,$cssFileName,"Compressed");
    }

    /**
    * Compile materialize.scss into $directory/materialize.css, and the css is compressed (it does NOT KEEP comments)
    *
    * @param string $directory Directory where materialize.css is going to be compiled
    *
    * @return void
    */
    function compileScssCrunched($directory, $cssFileName = "materialize.css") {
        $this->compile($directory,$cssFileName,"Crunched");
    }

    /**
    * Compile materialize.scss into $directory/materialize.css, with the format passed
    *
    * @param string $directory Directory where materialize.css is going to be compiled
    *
    * @param string $format Format to compile
    *
    * @return void
    *
    * @throws DirectoryNullException if directory is null
    */
    private function compile($directory,$cssFileName = "materialize.css",$format){
        if(isset($directory)) {
            if(substr($directory, -1)!="/"){
                $directory = $directory + "/";
            }

            $materializeSass = "materialize.scss";

            $scssCompiler = new Compiler();
            $scssCompiler->setImportPaths(MATERIALIZE_PATH."/sass");
            $scssCompiler->setFormatter("Leafo\ScssPhp\Formatter\\".$format);
            $cssFile = fopen($directory.$cssFileName, "w") or die("Unable to open file '".$directory.$cssFileName."'");
            $scssConverted = $scssCompiler->compile('@import "'.$materializeSass.'";');
            fwrite($cssFile, $scssConverted);
            fclose($cssFile);
        } else {
            throw new DirectoryNullException('compileScss($directory) needs a non null string', 1);
        }
    }

    /**
    * Override _variables.scss with your set colors
    * It does not compile css
    *
    * @return void
    */
    function setMaterializeVariables(){
        $this->makeSCSS->setMaterializeVariables();
    }
}
?>