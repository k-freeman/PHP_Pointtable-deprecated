PHP_Pointtable
==============

Note: this repository is deprecated and not being updated anymore.

**Update:**

Info1.php didn't change that much. It will search for corresponding lines etc automatically, depending on the first row in the .csv.

Info2.php however, calculates the mean and use some bootstrap diagrams; can be seen in the source code. That's why there is an additional .py script, which calculates the mean. It's a bit old and that's why its crappy. Should be understandable when reviewing examplefiles.


**Old:**

This small site is good to display points (of e.g. exercises) correlated to a certain person (in this case 'Matrikelnummern' are used).
Please open this readme in any plain file editor.

If you want to use this, all you have to do is:
1.) Place your 'pointsheet.csv' in the folder. Please note, that the first line will be ignored.
2.) Filter out all persons that allowed you to upload their points with adding them to the 'allowed.txt' and executing the 'php.class' afterwards.
3.) The last step will give you a 'points.dat', which will now only include the people that were mentioned in the 'allowed.txt'.
[optional: rename the 'points.dat' to something else for security reasons, please keep in mind to change the corresponding line in the 'info1.php' as well.]
4.) Upload the 'info1.php' and the 'points.dat' to your server.

The included '.csv' and 'allowed.txt' are examples.

**Kurz auf deutsch:**

Fügt eure .csv ein, benennt sie richtig. 
Schreibt alle nötigen Matrikelnummern in die allowed.txt
"java php" ausführen => points.dat generated.
Die PHP parsed jetzt alles automatisch. Hierbei sollte beachtet werden, dass die CSV-Spalten richtig benannt sind. Also: 1_1 1_2 1_3 für Aufgaben, 1_P für praktisch und 1_L für Ilias+LonCapa.
Eine Beispieldatei ist angehangen. Bitte fügt auch die Matrikelnummer 99999999 zu eurer allowed.txt hinzu, da diese Matrikelnummer die maximale Punktzahl speichert, sodass auch dies automatisch geparsed werden kann.
Wenn ihr das einmal angepasst habt, müsst ihr die php nie wieder ändern. Anzahl Exercises und Spalten werden jetzt eben automatisch ausgelesen.

Ladet nun die info1.php und die points.dat hoch, verschiebt sie in euren public_html Ordner. Falls hier keine index.php existiert, fügt bitte eine hinzu.

Hier eine Minimalbeispieldatei (eventuell müssen Umlaute noch aktiviert werden):

<?php
include("info1.php")
?>


