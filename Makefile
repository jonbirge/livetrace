# Define variables
IMAGE_NAME=livetrace
VERSION=0.1
DOCKER_HUB_USER=jonbirge

# Build the Docker image
build:
	docker build -t $(IMAGE_NAME):$(VERSION) .

# Push the Docker image to Docker Hub
push:
	docker tag $(IMAGE_NAME):$(VERSION) $(DOCKER_HUB_USER)/$(IMAGE_NAME):$(VERSION)
	docker push $(DOCKER_HUB_USER)/$(IMAGE_NAME):$(VERSION)

# Convenience command to build and push
all: build push

.PHONY: build push all

