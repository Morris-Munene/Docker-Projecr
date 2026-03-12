FROM python:3.11-slim

WORKDIR /app

# Copy and install dependencies first (caching trick)
COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# Now copy app source
COPY app.py .

# Set environment variable
ENV APP_ENV=production

# Run as non-root user
RUN useradd -m appuser
USER appuser

EXPOSE 5000

# Use gunicorn for production
CMD ["gunicorn", "--bind", "0.0.0.0:5000", "app:app"]