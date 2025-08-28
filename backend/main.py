from fastapi import FastAPI
from database.config import init_db
from routers.projects import router as projects_router

app = FastAPI()
init_db(app)

# Incluir o router de projetos.
app.include_router(projects_router, prefix="")