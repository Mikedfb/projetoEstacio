# routers/projects.py
from fastapi import APIRouter, HTTPException
from pydantic import BaseModel, Field

from database.models import Project

router = APIRouter()

# Modelos Pydantic para a validação e estrutura dos dados
class ProjectBase(BaseModel):
    titulo: str = Field(..., min_length=2, max_length=100)
    responsavel: str = Field(..., min_length=2, max_length=100)
    status: str = Field("pendente") 

@router.get("/")
async def root():
    return {"message": "Bem-vindo à API de Gerenciamento de Projetos com FastAPI! Acesse /docs para a documentação e /todos_os_projetos para ver a lista de projetos."}

@router.get("/todos_os_projetos")
async def get_all_projects():
    projects = await Project.all()
    response_projects = [{"id": project.id, "titulo": project.titulo, "responsavel": project.responsavel, "status": project.status, "created_at": project.created_at.strftime("%Y-%m-%d %H:%M:%S")} for project in projects]
    return {"projetos": response_projects}

@router.get("/projetos/{project_id}")
async def get_project(project_id: int):
    project = await Project.get_or_none(id=project_id)
    if not project:
        raise HTTPException(status_code=404, detail="Projeto não encontrado.")
    return {"id": project.id, "titulo": project.titulo, "responsavel": project.responsavel, "status": project.status, "created_at": project.created_at.strftime("%Y-%m-%d %H:%M:%S")}

@router.post("/adicionar_projeto")
async def add_project(project: ProjectBase):
    new_project = await Project.create(titulo=project.titulo, responsavel=project.responsavel, status=project.status)
    return {"id": new_project.id, "titulo": new_project.titulo, "responsavel": new_project.responsavel, "status": new_project.status, "created_at": new_project.created_at.strftime("%Y-%m-%d %H:%M:%S")}

@router.put("/atualizar_projeto/{project_id}")
async def update_project(project_id: int, project: ProjectBase):
    project_to_update = await Project.get_or_none(id=project_id)
    if not project_to_update:
        raise HTTPException(status_code=404, detail="Projeto não encontrado.")
    
    project_to_update.titulo = project.titulo
    project_to_update.responsavel = project.responsavel
    project_to_update.status = project.status
    await project_to_update.save()

    return {"message": "Projeto atualizado com sucesso!", "projeto_atualizado": {
        "id": project_to_update.id,
        "titulo": project_to_update.titulo,
        "responsavel": project_to_update.responsavel,
        "status": project_to_update.status,
        "created_at": project_to_update.created_at.strftime("%Y-%m-%d %H:%M:%S")
    }}

@router.delete("/deletar_projeto/{project_id}")
async def delete_project(project_id: int):
    project_to_delete = await Project.get_or_none(id=project_id)
    if not project_to_delete:
        raise HTTPException(status_code=404, detail="Projeto não encontrado.")
    
    await project_to_delete.delete()
    return {"message": "Projeto deletado com sucesso!"}