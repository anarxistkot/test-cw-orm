На вход подается сущность родительской организации.
Необходимо построить отчет, который вернет следующие данные:
transaction.id, product.name, transaction.sum, user.name, organization.name, transaction.completed_at

Данные необходимы по следующим условиям:
 - Транзакции имеют state = 'Completed'
 - Транзакции были совершены только активными пользователями из активных дочерних Организаций (ИНН дочерних Организаций совпадает с родительской)
 - Отчет должен содержать транзакции завершенные только за последние 3 дня

Данные в отчете должны быть отсортированы:
 - по дате завершения транзакции от большей к меньшей
