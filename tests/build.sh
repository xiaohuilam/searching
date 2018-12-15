./vendor/squizlabs/php_codesniffer/bin/phpcs
for file in $(find ./src -type f)
do
    php -l $file
done
phpunit