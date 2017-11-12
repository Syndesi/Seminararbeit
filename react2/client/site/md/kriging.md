# Kriging

Und die Erklärung zum Kriging... :D

## Formeln

Kriging-Formel

$\hat{Z}(S_0) = \sum\limits_{i=1}^{N}\lambda_iZ(S_i)$

| Modell-Typ   | Funktion                                                                                                                                                                                                                | Bild  |
|--------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-------|
| Sphärisch    | $y(x) = \begin{cases} 0 &\text{fuer } 0 = x \\ c_0 + c\bigg(\dfrac{3x}{2a}-\dfrac{1}{2}\Big(\dfrac{x}{a}^3\Big)\bigg) &\text{fuer } 0 < x \le a \\ c_0 + c &\text{fuer } a < x \end{cases}$                             |       |
| Kreisförmig  | $y(x) = \begin{cases} 0 &\text{fuer } 0 = x \\ c_0 + c\Bigg(1 - \dfrac{2}{\pi}\cos^{-1}\bigg(\dfrac{x}{a}\bigg)+\sqrt{1 - \dfrac{x^2}{a^2}}\Bigg) &\text{fuer } 0 < x \le a \\ c_0 + c &\text{fuer } a < x \end{cases}$ |       |
| Exponentiell | $y(x) = \begin{cases} 0 &\text{fuer } 0 = x \\ c_0 + c \Big(1 - e^{\large{\frac{-x}{r}}}\Big) &\text{fuer } 0 < x \end{cases}$                                                                                          |       |


---


1: [ArcGis](http://www.arcgis.com/features/index.html), eine internationale Firma für digitale Kartenerstellung und -Analyse, bietet im Rahmen seines eigenen Produkts ein Tutorial zum [Kriging-Verfahren](http://desktop.arcgis.com/de/arcmap/10.3/tools/3d-analyst-toolbox/how-kriging-works.htm).
2: [Connor Johnson](https://github.com/cjohnson318) bietet mit seinem Tutorial [Simple Kriging in Python](http://connor-johnson.com/2014/03/20/simple-kriging-in-python/) einen Beispielcode für Kriging in Python.