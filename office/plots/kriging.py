import numpy as np
import matplotlib.pyplot as plt


X1 = np.linspace(-2, 2, 400, endpoint=True)
c0 = 0;
c = 1;
a = 1;
Circle = c0 + c*(1 - (2/np.pi)*np.arccos(X1/a)+np.sqrt(1-np.power(X1, 2)/np.power(a, 2)))


#X2 = np.linspace(1, 2, 100, endpoint=True)
#Circle2 = 1

plt.plot(X1,Circle)
#plt.plot(X2,Circle2)

plt.show()