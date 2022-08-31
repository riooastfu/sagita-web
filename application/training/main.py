import pandas as pd
import sys
from chefboost import Chefboost as cb
import gc

parallelism_cases = [True]

if __name__ == '__main__':
    for enableParallelism in parallelism_cases:
        df = pd.read_csv("training.txt")
        config = {'algorithm': 'C4.5'}
        model = cb.fit(df, config = config, target_label = 'Status Gizi')

        cb.save_model(model, "model.pkl")

        df.iloc[0]

        prediction  = cb.predict(model,df.iloc[0])
        prediction

    prediction
    print("-------------------------")
    print("unit tests completed successfully...")



