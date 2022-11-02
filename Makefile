redis:
	kubectl port-forward svc/ow-redis 6379:6379

db:
	kubectl port-forward svc/ow-mysql 3306:3306 

dev:
	cd app/ && node ace serve --watch