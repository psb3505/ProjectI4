import pickle

foods = pickle.load(open('foods.pickle', 'rb'))
cosine_sim = pickle.load(open('cosine_sim.pickle', 'rb'))

def get_recommendations(food_name) :
    #음식 이름을 통해서 전체 데이터 기준 그 음식의 index 값을 얻기
    idx = foods[foods['CKG_NM'] == food_name].index[0]

    #코사인 유사도 매트릭스에서 idx에 해당하는 데이터를 (idx, 유사도) 형태
    sim_scores = list(enumerate(cosine_sim[idx]))

    #코사인 유사도 기준으로 내림차순 정렬
    sim_scores = sorted(sim_scores, key=lambda x: x[1], reverse=True)
    # print(sim_scores)

    #자기 자신을 제외한 10개의 추천 영화를 슬라이싱
    sim_scores = sim_scores[1:11]

    # 추천 음식 목록 10개의 인덱스 정보 추출
    food_indices = [i[0] for i in sim_scores]

    # 인덱스 정보를 통해 영화 제목 추출
    food_names = []
    for i in food_indices : 
        name = foods['CKG_NM'].iloc[i]
        food_names.append(name)

    return food_names


food_list = foods['CKG_NM'].values

food_names = get_recommendations('현미호두죽')

for i in food_names :
    print(i, end="\n")