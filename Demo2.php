<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wizard Steps</title>
    <style>
:root {
  --circle-size: clamp(1.5rem, 5vw, 3rem);
  --spacing: clamp(0.25rem, 2vw, 0.5rem);
}

.c-stepper {
  display: flex;
}

.c-stepper__item {
  display: flex;
  flex-direction: column;
  flex: 1;
  text-align: center;
  

  &:before {
    --size: 3rem;
    content: "";
    display: block;
    width: var(--circle-size);
    height: var(--circle-size);
    border-radius: 50%;
    background-color: lightgrey;
    background-color: red;
    opacity: 0.5;
    margin: 0 auto 0.33rem;
  }

  &:not(:last-child) {
    &:after {
      content: "";
      position: relative;
      top: calc(var(--circle-size) / 2);
      width: calc(100% - var(--circle-size) - calc(var(--spacing) * 2));
      left: calc(50% + calc(var(--circle-size) / 2 + var(--spacing)));
      height: 2px;
      background-color: #e0e0e0;
      order: -1;
    }
  }
}

.c-stepper__title {
  font-weight: bold;
  font-size: clamp(1rem, 4vw, 1.25rem);
  margin-bottom: 0.5rem;
}

.c-stepper__desc {
  color: grey;
  font-size: clamp(0.85rem, 2vw, 1rem);
  padding-left: var(--spacing);
  padding-right: var(--spacing);
}

.wrapper {
  max-width: 1000px;
  margin: 2rem auto 0;
}

body {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
    Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
  padding: 1rem;
}

*,
*:before,
*:after {
  box-sizing: border-box;
}
    </style>
</head>
<body>
<div class="wrapper option-1 option-1-1">
  <ol class="c-stepper">
    <li class="c-stepper__item">
      <h3 class="c-stepper__title">NHÁP</h3>
    </li>
    <li class="c-stepper__item">
      <h3 class="c-stepper__title">XÁC NHẬN</h3>
    </li>
    <li class="c-stepper__item">
      <h3 class="c-stepper__title">IN/GỬI EMAIL</h3>
    </li>
  </ol>
</div>
</body>
</html>
