# Stage 1: Microsoft Playwright image
FROM mcr.microsoft.com/playwright/python:v1.40.0-focal AS playwrightStage

# Set the working directory inside the container
WORKDIR /pythonTest

COPY e2eTest /pythonTest/

RUN rm -rf /pythonTest/venv/bin/python3

# Create a virtual environment and install Python dependencies
RUN pip install pytest pytest-playwright pytest-playwright-visual