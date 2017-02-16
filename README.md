## How to use it
    <!-- Change "MaterializecssCompilerInPHP" if you saved the library in a different folder -->
    <?php require_once("MaterializecssCompilerInPHP/MatCompiler.php"); ?>
    <html>
        <head></head>
        <body>
            <?php 
            // Instantiate an object MatCompiler
            $compiler = new MatCompiler();
            // Call compileScss($directory)
            //      $directory = Directory where is going to be saved materialize.css
            $compiler->compileScss(__DIR__."/css/");
            ?>
        </body>
    </html>

## Customization
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
##### compileScss ($directory)
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
    
##### compileScssNested ($directory)
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
##### compileScssCompact ($directory)
Compile scss showing each style on a different line
This will output:

    /*! Comment */
    .navigation ul { line-height:20px; color:blue; }
    
    .navigation ul a { color:red; }
    
    .footer .copyright { color:silver; }
##### compileScssCompressed ($directory)
Compile scss compressing the css, keeping comments
This will output:

    /* Comment*/.navigation ul{line-height:20px;color:blue;}.navigation ul a{color:red;}.footer .copyright{color:silver;}
##### compileScssCrunched ($directory)
It is the same as compileScssCompressed, but it removes comments
This will output:

    .navigation ul{line-height:20px;color:blue;}.navigation ul a{color:red;}.footer .copyright{color:silver;}
## Libraries used
- SCSS compiler written in PHP version 0.6.6 (September 11th, 2016): [SCSSPHP](https://github.com/leafo/scssphp) by [@leafo](https://github.com/leafo)
- [MaterializeCSS](http://materializecss.com) version 0.97.8 (Beta) (October 30th, 2016): [Materialize SASS](https://github.com/mkhairi/materialize-sass) by  [@mkhairi](https://github.com/mkhairi)
