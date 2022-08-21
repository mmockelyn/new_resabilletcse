.PHONY: helpers
helpers:
	php artisan clear-compiled
	php artisan ide-helper:generate
	php artisan ide-helper:models -F
	php artisan ide-helper:meta
