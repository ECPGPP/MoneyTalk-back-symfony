-- label and amount of all transaction in one moneypot (id)
select t.label, t.amount, money_pot_id from transaction t JOIN money_pot_transaction mtp on t.id = mtp.transaction_id;