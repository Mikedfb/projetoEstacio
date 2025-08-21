from tortoise import models, fields

class Book(models.Model):
    id = fields.IntField(pk=True)
    name = fields.CharField(max_length=255)
    autor = fields.CharField(max_length=255)
    
    created_at = fields.DatetimeField(auto_now_add=True)
    status = fields.CharField(
        max_length=20,
        default="ativo",
        choices=[("ativo", "Ativo"), ("pausado", "Pausado"), ("finalizado", "Finalizado")]
    )

    def __str__(self):
        return self.name

models_list = ["database.models"]