#APP COMPARER

- run `composer install`

To compare file run in console `php index.php {path_to_file} {path_to_file}...`
First is a file to compare with another. You must add more than two path.

Output:
```lcieslik@lukaszc smsapi $ php index.php ~/Desktop/test1.txt ~/Desktop/test2.txt ~/Desktop/test3.txt
   Compared file: /Users/lcieslik/Desktop/test2.txt
   Different line: 0 Diff: {"te":"tdase"}
   Different line: 0 Diff: {"tt\n":"ttas\n"}
   Different line: 1 Diff: {"\n":"ahdoagfasd;vasd"}
   Different line: 1 Diff: {"":"ahd;ka"}
   Different line: 1 Diff: {"":"adskh;f;s"}
   Different line: 1 Diff: {"":"as;da\n"}
   Different line: 2 Diff: {"Djahslfjgaldksgf":"Djahslfjgaldksgfaad"}
   Different line: 2 Diff: {"":"adnskafgnka"}
   
   Compared file: /Users/lcieslik/Desktop/test3.txt
   Different line: 0 Diff: {"te":"tdase"}
   Different line: 0 Diff: {"tt\n":"ttas\n"}
   Different line: 1 Diff: {"\n":"ahdoagfasd;vasd"}
   Different line: 1 Diff: {"":"ahd;ka"}
   Different line: 1 Diff: {"":"adskh;f;s"}
   Different line: 1 Diff: {"":"as;da\n"}
   Different line: 2 Diff: {"Djahslfjgaldksgf":"Djahslfjgaldksgfaad"}
   Different line: 2 Diff: {"":"adnskafgnkaa"}
   Different line: 2 Diff: {"":"ahda\n"}
   Different line: 3 Diff: {"":"Asdkfbh;akv"}
   Different line: 3 Diff: {"":"adslj\u2019akdv\\"}
   Different line: 3 Diff: {"":"a;cadsnkafh"}
   ```

Every report is stored in `/tmp` dir with name `test-{timestamp}.txt`
