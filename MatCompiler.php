<?php
require_once("config.php");
use Leafo\ScssPhp\Compiler;
class MatCompiler{
    //private $cssDirectoryName = MATCOMPILER_PATH . '/..';
    private $primaryColor1;
    private $primaryColor2;
    private $secondaryColor1;
    private $secondaryColor2;
    private $errorColor1;
    private $errorColor2;
    private $linkColor1;
    private $linkColor2;
    
    /**
    * Compile materialize.scss into $directory/materialize.css with the format as shown below:
    *
    * /*! Comment */
    /*
    * .navigation ul { line-height:20px; color:blue; }
    * 
    * .navigation ul a { color:red; }
    * 
    * .footer .copyright { color:silver; }
    */
    function compileScss($directory) {
        $this->compile($directory,"Leafo\ScssPhp\Formatter\Expanded");
    }

    /**
    * Compile materialize.scss into $directory/materialize.css, with the same format as compileScss(), but it is tabulated if is an inner class: 
    *
    *  /*! Comment */
    /*
    * .navigation ul {
    *   line-height: 20px;
    *   color: blue; }
    *     .navigation ul a {
    *       color: red; }
    * 
    * .footer .copyright {
    *   color: silver; }
    */
    function compileScssNested($directory){
        $this->compile($directory,"Leafo\ScssPhp\Formatter\Nested");
    }

    /**
    * Compile materialize.scss into $directory/materialize.css, and it every style is shown in a line:
    *
    *    /*! Comment */
    /*
    * .navigation ul { line-height:20px; color:blue; }
    *
    *.navigation ul a { color:red; }
    *
    *.footer .copyright { color:silver; }
    */
    function compileScssCompact($directory) {
        $this->compile($directory,"Leafo\ScssPhp\Formatter\Compact");
    }

    /**
    * Compile materialize.scss into $directory/materialize.css, and the css is compressed (it KEEPS comments)
    */
    function compileScssCompressed($directory) {
        $this->compile($directory,"Leafo\ScssPhp\Formatter\Compressed");
    }

    /**
    * Compile materialize.scss into $directory/materialize.css, and the css is compressed (it does NOT KEEP comments)
    */
    function compileScssCrunched($directory) {
        $this->compile($directory,"Leafo\ScssPhp\Formatter\Crunched");
    }

    /**
    * Compile materialize.scss into $directory/materialize.css, with the format passed
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
            $scssCompiler->setFormatter($format);
            $cssFile = fopen($directory.$cssFileName, "w") or die("Unable to open file '".$directory.$cssFileName."'");
            $scssConverted = $scssCompiler->compile('@import "'.$materializeSass.'";');
            fwrite($cssFile, $scssConverted);
            fclose($cssFile);
        } else {
            throw new Exception('compileScss($directory) needs a non null string.
             If you want to use current folder send \'./\'', 1);
        }
    }

    /**
    * Override _variables.scss with your set colors
    * It does not compile css
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