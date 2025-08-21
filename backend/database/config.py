from tortoise.contrib.fastapi import register_tortoise
from .models import models_list

def init_db(app):
    register_tortoise(
        app,
        db_url="postgres://postgres:9946@db:5432/fastapidb", 
        modules={"models": models_list},
        generate_schemas=True,
        add_exception_handlers=True,
    )