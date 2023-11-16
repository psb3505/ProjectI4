# -*- coding: utf-8 -*-
import pickle
import sys, io, json

# def get_recommendations(food_name) :
#     #음식 이름을 통해서 전체 데이터 기준 그 음식의 index 값을 얻기
#     try:
#         idx = foods[foods['CKG_NM'] == food_name].index[0]
#     except IndexError:
#         print("Error: Food '{}' not found.".format(food_name))
#         sys.exit(1)

#     #코사인 유사도 매트릭스에서 idx에 해당하는 데이터를 (idx, 유사도) 형태
#     sim_scores = list(enumerate(cosine_sim[idx]))

#     #코사인 유사도 기준으로 내림차순 정렬
#     sim_scores = sorted(sim_scores, key=lambda x: x[1], reverse=True)

#     #자기 자신을 제외한 10개의 추천 영화를 슬라이싱
#     sim_scores = sim_scores[1:11]

#     # 추천 음식 목록 10개의 인덱스 정보 추출
#     food_indices = [i[0] for i in sim_scores]

#     # 인덱스 정보를 통해 영화 제목 추출
#     food_names = []
#     for i in food_indices : 
#         name = foods['CKG_NM'].iloc[i]
#         food_names.append(name)

#     return food_names

# 명령행 인자로부터 음식 이름을 가져옴
food_name_from_php = json.loads(sys.argv[1])

# food_names = get_recommendations(food_name_from_php)

for i in food_name_from_php :
    print(i)