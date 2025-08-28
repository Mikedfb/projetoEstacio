from tortoise import models, fields

class Project(models.Model):
    id = fields.IntField(pk=True)
    titulo = fields.CharField(max_length=255)
    responsavel = fields.CharField(max_length=255)
    
    created_at = fields.DatetimeField(auto_now_add=True)
    status = fields.CharField(
        max_length=20,
        default="pendente",
        choices=[("pendente", "Pendente"), ("em_progresso", "Em Progresso"), ("concluido", "Concluido")]
    )

    def __str__(self):
        return self.titulo

models_list = ["database.models"]