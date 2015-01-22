integrityCheck - Comparison for SugarCRM module installer
==========

File Issues On Demand

- pre_execute/0.php
- Invalid usage of a function ziparchive()
- Invalid usage of a function pathinfo()
- Invalid usage of a function pathinfo()
- Invalid usage of a function file_exists()


The file "/pre_execute/0.php" executes after "scripts/pre_install.php", so don't copy in pre_install files from package that are defined in $installdefs["copy"] array from manifest :) 

