from tortoise import models, fields

class Book(models.Model):
    id = fields.IntField(pk=True)
    name = fields.CharField(max_length=255)
    autor = fields.CharField(max_length=255)

    def _str_(self):
        return self.name


models_list = ["database.models"]
