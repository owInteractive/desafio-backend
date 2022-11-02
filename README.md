## (Docker) Os comandos devem ser rodados na raiz do diretório

# Build das imagens Docker:

docker build -t mysql-ow -f docker/Database.dockerfile .
docker build -t redis-ow -f docker/Redis.dockerfile .
docker build -t app-ow -f docker/Application.dockerfile .

# Rodar os containers no Docker:

docker run -d -p 3306:3306 -v /var/lib/mysql:/var/lib/mysql --name mysql mysql-ow
docker run -d -p 6379:6379 -v /var/lib/redis:/data --name redis-ow redis-ow
docker run -d -p 4000:4000 --name app-ow app-ow





## (Kubernetes) Os comandos devem ser rodados na raiz do diretório

# Criar os deploys e os pods

kubectl apply -f k8s/mysql.yaml
kubectl apply -f k8s/redis.yaml

# Fazer o portforward (apenas) para rodar a aplicação localmente

kubectl port-forward svc/ow-mysql 3306:3306
kubectl port-forward svc/ow-redis 6379:6379