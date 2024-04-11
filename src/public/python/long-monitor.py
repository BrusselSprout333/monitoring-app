import sys
import cgitb
cgitb.enable()

import time
import csv
import cv2
import os

def check_stop_flag():
    return os.path.exists('python/stop_flag.txt')

# Инициализируем веб-камеру
cap = cv2.VideoCapture(0)

# Создаем классификатор лиц (можно использовать другой XML-файл)
face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')

# Отключаем буферизацию stdout
sys.stdout.flush()

# Создаем CSV-файл для записи данных
csv_file = open('python/long_monitor.csv', mode='w', newline='')
csv_writer = csv.writer(csv_file)
csv_writer.writerow(['Time', 'Brightness', 'Face Coordinates', 'Face Area', 'Approximate Distance (cm)'])

start_time = time.time()
duration = 36000  # Продолжительность выполнения программы (в секундах) 36000 - 10 ч

# Физические параметры для расчета расстояния (примерные значения)
# Фокусное расстояние камеры (мм)
focal_length = 1000
# Размер лица в реальной жизни (мм x мм)
real_face_width = 140
real_face_height = 180
last_save_time = time.time()

while (time.time() - start_time) < duration:
    # Считываем кадр с веб-камеры
    ret, frame = cap.read()

    if not ret:
        break

    # Преобразовываем кадр в оттенки серого для анализа
    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)

    # Вычисляем среднюю яркость кадра
    brightness = gray.mean()

    # Обнаружение лиц на кадре
    faces = face_cascade.detectMultiScale(gray, scaleFactor=1.3, minNeighbors=5, minSize=(30, 30))

    # Записываем данные о каждом обнаруженном лице
    for (x, y, w, h) in faces:
        # Вычисляем площадь лица
        face_area = w * h

        # Рассчитываем приблизительное расстояние от экрана (в см) на основе размера лица и фокусного расстояния
        approximate_distance = (focal_length * real_face_width) / (w * 10)  # w * 10 для перевода в миллиметры

        # Отображение лиц на кадре
        cv2.rectangle(frame, (x, y), (x + w, y + h), (0, 255, 0), 2)

        current_time = time.time()
        if current_time - last_save_time >= 1:
            csv_writer.writerow([current_time, brightness, (x, y, w, h), face_area, approximate_distance])
            csv_file.flush()
            last_save_time = current_time

    # Отображение кадра
    cv2.imshow('Face and Brightness Detection', frame)

    # Для завершения работы нажмите Esc
    key = cv2.waitKey(1)
    if key == 27:  # 27 - это код клавиши Esc
        break

    if check_stop_flag():
        csv_writer.writerow(['Received stop signal, exiting...'])
        break


# Закрываем CSV-файл и освобождаем ресурсы
csv_file.close()
cap.release()
cv2.destroyAllWindows()
