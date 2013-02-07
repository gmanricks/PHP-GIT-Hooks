PHP-GIT-Hooks
=============

A PHP Class for Helping you run custom functions in Git Hooks

## Usage

A created this class as verbose as possible, in terms of function names. So to run a simple function with a message before and after it you would type:
```php
  $ph = new PHook;
  
  $ph->say("Downloading some Gunther ... ")
     ->thenRun(function(){
        file_put_contents("Gunther.png", file_get_contents("https://dl.dropbox.com/u/30949096/Gunther.png"));
     })->andFinallySay("Done");
```
This will Download a picture of a Cool Penguin to your PC.

There are more advanced commands like `onTrigger` which will only run the command when a special trigger keyword is found in the current commit message.

You may also add another Message to display when the command fails by using the `unlessFails` Command and all messages can be color coded using color names like so:
```php
  $ph->say("This ")->green("Sentence ")->red("is Super ")->white("Colorful")->withoutACommand();
```
The `withoutACommand` Function will just display the message without running any functions, it is worth noting that if you set a trigger, even though no function will be run, the message won't be displayed without the keyword.

The supported Colors are:
  - black
  - red
  - green
  - yellow
  - blue
  - magenta
  - cyan
  - white
  - clear (no Formatting)
  - plain (reset to default Formatting)

For more Examples Consult the TestHook file.

## Credits

This is a Project created by Gabriel Manricks.
You can follow me on twitter at: ![@gabrielmanricks](https://twitter.com/GabrielManricks)

### P.S.

Even though I wrote that this is a Git Hook Library, the only real Git related function is the triggers, so if you just need a Terminal printer with Color Support then this will work great (including the command part).
