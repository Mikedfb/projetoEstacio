# Usa uma imagem base oficial do Python
FROM python:3.9-slim

# Define o diretório de trabalho dentro do container
WORKDIR /app

# Copia o arquivo de requisitos e os instala
COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# Copia o restante dos arquivos da sua API
COPY . /app

# O comando para iniciar a aplicação
CMD ["uvicorn", "main:app", "--host", "0.0.0.0", "--reload"]