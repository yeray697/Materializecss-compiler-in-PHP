<?php
require_once("config.php");
use Leafo\ScssPhp\Compiler;
/**
* Class that manages materialize.scss
* @author yeray697
*/
class MatCompiler{

    //Variables
    private $primaryColor1;
    private $primaryColor2;
    private $secondaryColor1;
    private $secondaryColor2;
    private $errorColor1;
    private $errorColor2;
    private $linkColor1;
    private $linkColor2;
    
    //Methods

    /**
    * Check if a color is valid
    *
    * @param string $color Color to check if is valid
    *
    * @return boolean Indicates if it is valid
    *
    * @throws InvalidColorException if color is not valid
    */
    private function isValidColor($color){
        $validColors = array(
            0 => "red",
            1 => "pink",
            2 => "purple",
            3 => "deep-purple",
            4 => "indigo",
            5 => "blue",
            6 => "light-blue", 
            7 => "cyan",
            8 => "teal",
            9 => "green", 
            10 => "light-green",
            11 => "lime",
            12 => "yellow", 
            13 => "amber",
            14 => "orange",
            15 => "deep-orange", 
            16 => "brown",
            17 => "grey",
            18 => "blue-grey");
        if (in_array($color, $validColors))
            return true;
        throw new InvalidColorException($color." color is not valid", 1);
    }

    /**
    * Check if a tone is valid
    *
    * @param string $tone Tone to check if is valid
    *
    * @param string $color Color to check if tone is valid (grey and brown can not have accent tone)    
    *
    * @return boolean Indicates if it is valid
    *
    * @throws InvalidToneException if tone is not valid
    */
    private function isValidTone($tone,$color){
        $validTones = array(
            0 => "lighten-5",
            1 => "lighten-4",
            2 => "lighten-3",
            3 => "lighten-2",
            4 => "lighten-1",
            5 => "base",
            6 => "darken-1", 
            7 => "darken-2",
            8 => "darken-3",
            9 => "darken-4");
        $accentTones = array(
            10 => "accent-1",
            11 => "accent-2",
            12 => "accent-3", 
            13 => "accent-4");
            
        $result = in_array($tone,$accentTones);
        if($color == "brown" || $color == "grey") {
            if ($result){
                throw new InvalidToneException($color." color can not have accent color", 2);
            } else {
                $result = in_array($tone,$validTones) || in_array($tone,$accentTones);
            }
        }
        else {
            $result = $result?true:in_array($tone,$validTones);
        }
        if (!$result) //The tone does not exist
            throw new InvalidToneException($tone." is not a valid tone", 1);
        return $result;
    }

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
        if($this->isValidColor($color) && $this->isValidTone($tone,$color)) {
            $this->primaryColor1 = $color;
            $this->primaryColor2 = $tone;
            if ($updateFile) {
                $this->setMaterializeVariables();
            }
        }
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
        if($this->isValidColor($color) && $this->isValidTone($tone,$color)) {
            $this->secondaryColor1 = $color;
            $this->secondaryColor2 = $tone;
            if ($updateFile) {
                $this->setMaterializeVariables();
            }
        }
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
        if($this->isValidColor($color) && $this->isValidTone($tone,$color)) {
            $this->successColor1 = $color;
            $this->successColor2 = $tone;
            if ($updateFile) {
                $this->setMaterializeVariables();
            }
        }
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
        if($this->isValidColor($color) && $this->isValidTone($tone,$color)) {
            $this->errorColor1 = $color;
            $this->errorColor2 = $tone;
            if ($updateFile) {
                $this->setMaterializeVariables();
            }
        }
    }

    /**
    * Set the links color
    *
    * @param string $directory Directory where materialize.css is going to be compiled
    *
    * @return void
    */
    function setLinkColor($color,$tone,$updateFile = false){
        if($this->isValidColor($color) && $this->isValidTone($tone,$color)) {
            $this->linkColor1 = $color;
            $this->linkColor2 = $tone;
            if ($updateFile) {
                $this->setMaterializeVariables();
            }
        }
    }

    

    /**
    * Compile materialize.scss into $directory/materialize.css
    *
    * @param string $directory Directory where materialize.css is going to be compiled
    *
    * @return void
    */
    function compileScss($directory) {
        $this->compile($directory,"Expanded");
    }

    /**
    * Compile materialize.scss into $directory/materialize.css, with the same format as compileScss(), but it is tabulated if is an inner class
    *
    * @param string $directory Directory where materialize.css is going to be compiled
    *
    * @return void
    */
    function compileScssNested($directory){
        $this->compile($directory,"Nested");
    }

    /**
    * Compile materialize.scss into $directory/materialize.css, and it every style is shown in a line
    *
    * @param string $directory Directory where materialize.css is going to be compiled
    *
    * @return void
    */
    function compileScssCompact($directory) {
        $this->compile($directory,"Compact");
    }

    /**
    * Compile materialize.scss into $directory/materialize.css, and the css is compressed (it KEEPS comments)
    *
    * @param string $directory Directory where materialize.css is going to be compiled
    *
    * @return void
    */
    function compileScssCompressed($directory) {
        $this->compile($directory,"Compressed");
    }

    /**
    * Compile materialize.scss into $directory/materialize.css, and the css is compressed (it does NOT KEEP comments)
    *
    * @param string $directory Directory where materialize.css is going to be compiled
    *
    * @return void
    */
    function compileScssCrunched($directory) {
        $this->compile($directory,"Crunched");
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
    private function compile($directory,$format){
        if(isset($directory)) {
            if(substr($directory, -1)!="/"){
                $directory = $directory + "/";
            }
            $materializeSass = "materialize.scss";
            $cssFileName = "materialize.css";

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
        
        $this->primaryColor1 = (isset($this->primaryColor1))?$this->primaryColor1:"materialize-red";
        $this->primaryColor2 = (isset($this->primaryColor2))?$this->primaryColor2:"lighten-2";
        
        $this->secondaryColor1 = (isset($this->secondaryColor1))?$this->secondaryColor1:"teal";
        $this->secondaryColor2 = (isset($this->secondaryColor2))?$this->secondaryColor2:"lighten-1";
        
        $this->successColor1 = (isset($sthis->uccessColor1))?$this->successColor1:"green";
        $this->successColor2 = (isset($this->successColor2))?$this->successColor2:"base";
        
        $this->errorColor1 = (isset($this->errorColor1))?$this->errorColor1:"red";
        $this->errorColor2 = (isset($this->errorColor2))?$this->errorColor2:"base";
        
        $this->linkColor1 = (isset($this->linkColor1))?$this->linkColor1:"light-blue";
        $this->linkColor2 = (isset($this->linkColor2))?$this->linkColor2:"darken-1";

        $sassVariablesRoot = MATERIALIZE_PATH."/sass/components/_variables.scss";
        

        $colors = '$primary-color: color("'.$this->primaryColor1.'", "'.$this->primaryColor2.'") !default;
        $primary-color-light: lighten($primary-color, 15%) !default;
        $primary-color-dark: darken($primary-color, 15%) !default;

        $secondary-color: color("'.$this->secondaryColor1.'", "'.$this->secondaryColor2.'") !default;
        $success-color: color("'.$this->successColor1.'", "'.$this->successColor2.'") !default;
        $error-color: color("'.$this->errorColor1.'", "'.$this->errorColor2.'") !default;
        $link-color: color("'.$this->linkColor1.'", "'.$this->linkColor2.'") !default;';

        $cssFile = fopen($sassVariablesRoot, "w") or die("Unable to open file!");

        fwrite($cssFile, $this->initFile.$colors.$this->endFile);
        fclose($cssFile);
    }
    private $initFile = "// ==========================================================================
// Materialize variables
// ==========================================================================
//
// Table of Contents:
//
//  1. Colors
//  2. Badges
//  3. Buttons
//  4. Cards
//  5. Collapsible
//  6. Chips
//  7. Date Picker
//  8. Dropdown
//  10. Forms
//  11. Global
//  12. Grid
//  13. Navigation Bar
//  14. Side Navigation
//  15. Photo Slider
//  16. Spinners | Loaders
//  17. Tabs
//  18. Tables
//  19. Toasts
//  20. Typography
//  21. Footer
//  22. Flow Text
//  23. Collections
//  24. Progress Bar



// 1. Colors
// ==========================================================================

";
    private $endFile = '


// 2. Badges
// ==========================================================================

$badge-bg-color: $secondary-color !default;
$badge-height: 22px !default;


// 3. Buttons
// ==========================================================================

// Shared styles
$button-border: none !default;
$button-background-focus: lighten($secondary-color, 4%) !default;
$button-font-size: 1.3rem !default;
$button-height: 36px !default;
$button-padding: 0 2rem !default;
$button-radius: 2px !default;

// Disabled styles
$button-disabled-background: #DFDFDF !default;
$button-disabled-color: #9F9F9F !default;

// Raised buttons
$button-raised-background: $secondary-color !default;
$button-raised-background-hover: lighten($button-raised-background, 5%) !default;
$button-raised-color: #fff !default;

// Large buttons
$button-large-icon-font-size: 1.6rem !default;
$button-large-height: $button-height * 1.5 !default;

// Flat buttons
$button-flat-color: #343434 !default;
$button-flat-disabled-color: lighten(#999, 10%) !default;

// Floating buttons
$button-floating-background: $secondary-color !default;
$button-floating-background-hover: $button-floating-background !default;
$button-floating-color: #fff !default;
$button-floating-size: 40px !default;
$button-floating-large-size: 56px !default;
$button-floating-radius: 50% !default;


// 4. Cards
// ==========================================================================

$card-padding: 24px !default;
$card-bg-color: #fff !default;
$card-link-color: color("orange", "accent-2") !default;
$card-link-color-light: lighten($card-link-color, 20%) !default;


// 5. Collapsible
// ==========================================================================

$collapsible-height: 3rem !default;
$collapsible-line-height: $collapsible-height !default;
$collapsible-header-color: #fff !default;
$collapsible-border-color: #ddd !default;


// 6. Chips
// ==========================================================================

$chip-bg-color: #e4e4e4 !default;
$chip-border-color: #9e9e9e !default;
$chip-selected-color: #26a69a !default;
$chip-margin: 5px !default;


// 7. Date Picker
// ==========================================================================

$datepicker-weekday-bg: darken($secondary-color, 7%) !default;
$datepicker-date-bg: $secondary-color !default;
$datepicker-year: rgba(255, 255, 255, .4) !default;
$datepicker-focus: rgba(0,0,0, .05) !default;
$datepicker-selected: $secondary-color !default;
$datepicker-selected-outfocus: desaturate(lighten($secondary-color, 35%), 15%) !default;


// 8. Dropdown
// ==========================================================================

$dropdown-bg-color: #fff !default;
$dropdown-hover-bg-color: #eee !default;
$dropdown-color: $secondary-color !default;
$dropdown-item-height: 50px !default;


// 9. Fonts
// ==========================================================================

$roboto-font-path: "../fonts/roboto/" !default;


// 10. Forms
// ==========================================================================

// Text Inputs + Textarea
$input-height: 3rem !default;
$input-border-color: color("grey", "base") !default;
$input-border: 1px solid $input-border-color !default;
$input-background: #fff !default;
$input-error-color: $error-color !default;
$input-success-color: $success-color !default;
$input-focus-color: $secondary-color !default;
$input-font-size: 1rem !default;
$input-margin: 0 0 20px 0 !default;
$input-padding: 0 !default;
$input-transition: all .3s !default;
$label-font-size: .8rem !default;
$input-disabled-color: rgba(0,0,0, .26) !default;
$input-disabled-solid-color: #BDBDBD !default;
$input-disabled-border: 1px dotted $input-disabled-color !default;
$input-invalid-border: 1px solid $input-error-color !default;
$placeholder-text-color: lighten($input-border-color, 20%) !default;

// Radio Buttons
$radio-fill-color: $secondary-color !default;
$radio-empty-color: #5a5a5a !default;
$radio-border: 2px solid $radio-fill-color !default;

// Range
$range-height: 14px !default;
$range-width: 14px !default;
$track-height: 3px !default;

// Select
$select-border: 1px solid #f2f2f2 !default;
$select-background: rgba(255, 255, 255, 0.90) !default;
$select-focus: 1px solid lighten($secondary-color, 47%) !default;
$select-padding: 5px !default;
$select-radius: 2px !default;
$select-disabled-color: rgba(0,0,0,.3) !default;

// Switches
$switch-bg-color: $secondary-color !default;
$switch-checked-lever-bg: desaturate(lighten($secondary-color, 25%), 25%) !default;
$switch-unchecked-bg: #F1F1F1 !default;
$switch-unchecked-lever-bg: #818181 !default;
$switch-radius: 15px !default;


// 11. Global
// ==========================================================================

// Media Query Ranges
$small-screen-up: 601px !default;
$medium-screen-up: 993px !default;
$large-screen-up: 1201px !default;
$small-screen: 600px !default;
$medium-screen: 992px !default;
$large-screen: 1200px !default;

$medium-and-up: "only screen and (min-width : #{$small-screen-up})" !default;
$large-and-up: "only screen and (min-width : #{$medium-screen-up})" !default;
$small-and-down: "only screen and (max-width : #{$small-screen})" !default;
$medium-and-down: "only screen and (max-width : #{$medium-screen})" !default;
$medium-only: "only screen and (min-width : #{$small-screen-up}) and (max-width : #{$medium-screen})" !default;


// 12. Grid
// ==========================================================================

$num-cols: 12 !default;
$gutter-width: 1.5rem !default;
$element-top-margin: $gutter-width/3 !default;
$element-bottom-margin: ($gutter-width*2)/3 !default;


// 13. Navigation Bar
// ==========================================================================

$navbar-height: 64px !default;
$navbar-line-height: $navbar-height !default;
$navbar-height-mobile: 56px !default;
$navbar-line-height-mobile: $navbar-height-mobile !default;
$navbar-font-size: 1rem !default;
$navbar-font-color: #fff !default;
$navbar-brand-font-size: 2.1rem !default;

// 14. Side Navigation
// ==========================================================================

$sidenav-font-size: 14px !default;
$sidenav-font-color: rgba(0,0,0,.87) !default;
$sidenav-bg-color: #fff !default;
$sidenav-padding: 16px !default;
$sidenav-item-height: 48px !default;
$sidenav-line-height: $sidenav-item-height !default;


// 15. Photo Slider
// ==========================================================================

$slider-bg-color: color(\'grey\', \'base\') !default;
$slider-bg-color-light: color(\'grey\', \'lighten-2\') !default;
$slider-indicator-color: color(\'green\', \'base\') !default;


// 16. Spinners | Loaders
// ==========================================================================

$spinner-default-color: $secondary-color !default;


// 17. Tabs
// ==========================================================================

$tabs-underline-color: $primary-color-light !default;
$tabs-text-color: $primary-color !default;
$tabs-bg-color: #fff !default;


// 18. Tables
// ==========================================================================

$table-border-color: #d0d0d0 !default;
$table-striped-color: #f2f2f2 !default;


// 19. Toasts
// ==========================================================================

$toast-height: 48px !default;
$toast-color: #323232 !default;
$toast-text-color: #fff !default;


// 20. Typography
// ==========================================================================

$off-black: rgba(0, 0, 0, 0.87) !default;
// Header Styles
$h1-fontsize: 4.2rem !default;
$h2-fontsize: 3.56rem !default;
$h3-fontsize: 2.92rem !default;
$h4-fontsize: 2.28rem !default;
$h5-fontsize: 1.64rem !default;
$h6-fontsize: 1rem !default;


// 21. Footer
// ==========================================================================

$footer-bg-color: $primary-color !default;


// 22. Flow Text
// ==========================================================================

$range : $large-screen - $small-screen !default;
$intervals: 20 !default;
$interval-size: $range / $intervals !default;


// 23. Collections
// ==========================================================================

$collection-border-color: #e0e0e0 !default;
$collection-bg-color: #fff !default;
$collection-active-bg-color: $secondary-color !default;
$collection-active-color: lighten($secondary-color, 55%) !default;
$collection-hover-bg-color: #ddd !default;
$collection-link-color: $secondary-color !default;
$collection-line-height: 1.5rem !default;


// 24. Progress Bar
// ==========================================================================

$progress-bar-color: $secondary-color !default;
';
}
?>