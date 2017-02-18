## Information
"Materializecss compiler in PHP" is an auxiliar library that offers to the user methods to use materializecss with sass in PHP (Ruby is not required!).
Right now, this version works fine with a Wordpress theme, even without saving together all variables to a file, provided that these variables are managed by wordpress customization panel!
Next version will be possible to manage them in a file.
## How to use it
    <!-- Change "MaterializecssCompilerInPHP" if you saved the library in a different folder -->
    <?php require_once("MaterializecssCompilerInPHP/MatCompiler.php"); ?>
    <html>
        <head></head>
        <body>
            <?php 
            // Instantiate an object MatCompiler
            $compiler = new MatCompiler();
            $compiler->setPrimaryColor("black","");
            $compiler->setSecondaryColor("blue","lighten-1");
            $compiler->setNavbarFontColor("white","",true);
            //You don't need this method if you pass true in the last setter used
            //$compiler->setMaterializeVariables();
            
            // Call compileScss($directory)
            //      $directory = Directory where is going to be saved materialize.css
            $compiler->compileScss(__DIR__."/css/");
            ?>
        </body>
    </html>

## Customization
#### Setting colors

    /**
    * Override _variables.scss with your set colors
    * It does not compile css
    * @return void
    */
    function setMaterializeVariables(){
        $this->makeSCSS->setMaterializeVariables();
    }
    
    /**
    * Tries setting the primary color
    * @param string $color Color to set
    * @param string $tone Tone to set   
    * @param boolean $updateFile Update _variables.scss after set the color (default = false)   
    * @return void
    */
    void setPrimaryColor($color,$tone,$updateFile = false)
    
    /**
    * Tries setting the secondary color
    * @param string $color Color to set
    * @param string $tone Tone to set   
    * @param boolean $updateFile Update _variables.scss after set the color (default = false)   
    * @return void
    */
    void setSecondaryColor($color,$tone,$updateFile = false)
    
    /**
    * Tries setting the success color
    * @param string $color Color to set
    * @param string $tone Tone to set   
    * @param boolean $updateFile Update _variables.scss after set the color (default = false)   
    * @return void
    */
    void setSuccessColor($color,$tone,$updateFile = false)
    
    /**
    * Tries setting the error color
    * @param string $color Color to set
    * @param string $tone Tone to set   
    * @param boolean $updateFile Update _variables.scss after set the color (default = false)   
    * @return void
    */
    void setErrorColor($color,$tone,$updateFile = false)
    
    /**
    * Set the links color
    * @param string $color Color to set
    * @param string $tone Tone to set   
    * @param boolean $updateFile Update _variables.scss after set the color (default = false)   
    * @return void
    */
    function setLinkColor($color,$tone,$updateFile = false)
    
    /**
    * Set the card links color
    * @param string $color Color to set
    * @param string $tone Tone to set   
    * @param boolean $updateFile Update _variables.scss after set the color (default = false)   
    * @return void
    */
    function setCardLinkColor($color,$tone,$updateFile = false)
    
    /**
    * Set the slider button color
    * @param string $color Color to set
    * @param string $tone Tone to set   
    * @param boolean $updateFile Update _variables.scss after set the color (default = false)   
    * @return void
    */
    function setSliderButtonColor($color,$tone,$updateFile = false)
    
    /**
    * Set the navigation bar font color
    * @param string $color Color to set
    * @param string $tone Tone to set   
    * @param boolean $updateFile Update _variables.scss after set the color (default = false)   
    * @return void
    */
    function setNavbarFontColor($color,$tone,$updateFile = false)
#### Compiling
Given the following SCSS:
    
    /*! Comment */
    .navigation {
        ul {
            line-height: 20px;
            color: blue;
            a {
                color: red;
            }
        }
    }
    
    .footer {
        .copyright {
            color: silver;
        }
    }
    
You can compile it in 5 different ways
##### compileScss ($directory, $cssFileName = "materialize.css")
Compile scss with a high readability
This will output:

    /*! Comment */
    .navigation ul {
      line-height: 20px;
      color: blue;
    }
    .navigation ul a {
      color: red;
    }
    .footer .copyright {
      color: silver;
    }
    
##### compileScssNested ($directory, $cssFileName = "materialize.css")
It is the same as compileScss, but it tabulates styles if the child of above style
This will output:

    /*! Comment */
    .navigation ul {
      line-height: 20px;
      color: blue; }
        .navigation ul a {
          color: red; }
    
    .footer .copyright {
      color: silver; }
##### compileScssCompact ($directory, $cssFileName = "materialize.css")
Compile scss showing each style on a different line
This will output:

    /*! Comment */
    .navigation ul { line-height:20px; color:blue; }
    
    .navigation ul a { color:red; }
    
    .footer .copyright { color:silver; }
##### compileScssCompressed ($directory, $cssFileName = "materialize.min.css")
Compile scss compressing the css, keeping comments
This will output:

    /* Comment*/.navigation ul{line-height:20px;color:blue;}.navigation ul a{color:red;}.footer .copyright{color:silver;}
##### compileScssCrunched ($directory, $cssFileName = "materialize.min.css")
It is the same as compileScssCompressed, but it removes comments
This will output:

    .navigation ul{line-height:20px;color:blue;}.navigation ul a{color:red;}.footer .copyright{color:silver;}
## Author
- Yeray Ruiz [@yeray697](http://github.com/yeray697) ([yeray@ncatz.com](mailto:yeray@ncatz.com)) -> [yeray.ncatz.com](https://yeray.ncatz.com)
## Libraries used
- SCSS compiler written in PHP version 0.6.6 (September 11th, 2016): [SCSSPHP](https://github.com/leafo/scssphp) by [@leafo](https://github.com/leafo)
- [MaterializeCSS](http://materializecss.com) version 0.97.8 (Beta) (October 30th, 2016): [Materialize SASS](https://github.com/mkhairi/materialize-sass) by  [@mkhairi](https://github.com/mkhairi)
