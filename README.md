PHP_Pointtable
==============

This small site is good to display points (of e.g. exercises) correlated to a certain person (in this case 'Matrikelnummern' are used).

If you want to use this, all you have to do is:
1.) Place your 'pointsheet.csv' in the folder. Please note, that the first line will be ignored.
2.) Filter out all persons that allowed you to upload their points with adding them to the 'allowed.txt' and executing the 'php.class' afterwards.
3.) The last step will give you a 'points.dat', which will now only include the people that were mentioned in the 'allowed.txt'.
[optional: rename the 'points.dat' to something else for security reasons, please keep in mind to change the corresponding line in the 'info1.php' as well.]
4.) Upload the 'info1.php' and the 'points.dat' to your server.

If you want to modify e.g. maxpoints or the arrangement of the '.csv'-columns, also edit the 'info1.php'. These passages are marked with "/**MODIFY START**/".

The included '.csv' and 'allowed.txt' are examples.

Kurz auf deutsch:

Fügt eure .csv ein, benennt sie richtig. 
Schreibt alle nötigen Matrikelnummern in die allowed.txt
"java php" ausführen => points.dat generated.
Ändert die Info1.php an den relevanten Stellen (/**MODIFY START**/), hier könnt ihr einfach anhand des Indexes die Spaltennummer ändern. Das $a_m array speichert die maximale Punktzahlen in folgender Reihenfolge: (1_1, 1_2, 1_3, A, 2_1, 2_2, 2_3, B), wobei Buchstaben für praktische Testate stehen.

Ladet nun die info1.php und die points.dat hoch, verschiebt sie in euren public_html Ordner. Falls hier keine index.php existiert, fügt bitte eine hinzu.

Hier eine Minimalbeispieldatei:

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" 
	"http://www.w3.org/TR/html4/strict.dtd">
<?php
include("info1.php")
?>


