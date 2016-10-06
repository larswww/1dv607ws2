# 1dv607ws2

**View**

View är i sig en main layout med html-head och body. I bodyn trycks det in en partial. View tar även ett argument för title, men det är det inget krav på så inget som behöver implementeras

View förväntar sig ett partialObject och eventuell data (new PartialName(), array data);

Vyn är väldigt verbos. Inga krav ställs på ett nice flöde eller bra felhantering. Vid ett eventuellt databasfel finns det en egen partialklass som tar hand om det. Kanske ändra till en och samma partial för alla fellmeddelanden och skicka in ett färdiggenererat meddelande istället?
