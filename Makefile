# Define variables
IMAGE_NAME=livetrace
VERSION=latest
DOCKER_HUB_USER=jonbirge

# Build the Docker image
build:
	docker build -t $(IMAGE_NAME):$(VERSION) .

# Push the Docker image to Docker Hub
push: build
	docker tag $(IMAGE_NAME):$(VERSION) $(DOCKER_HUB_USER)/$(IMAGE_NAME):$(VERSION)
	docker push $(DOCKER_HUB_USER)/$(IMAGE_NAME):$(VERSION)

# No cache build (a clear abuse of 'make clean')
clean:
	docker build --no-cache .

# Run locally for testing
run: build
	docker run  --name livetrace_test -d -p 8080:80 $(IMAGE_NAME):$(VERSION)

# Stop the local test
stop:
	docker stop livetrace_test
	docker rm livetrace_test

# Convenience command to build and push
all: build push

.PHONY: build push all
