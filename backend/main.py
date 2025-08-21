from fastapi import FastAPI
from database.config import init_db
from routers.books import router as books_router

app = FastAPI()
init_db(app)

# Incluir o router de livros.
app.include_router(books_router, prefix="")

