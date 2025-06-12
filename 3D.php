<?php
session_start();
$sizeMap = ['S' => 'small', 'M' => 'medium', 'L' => 'large', 'XL' => 'xlarge'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['size'])) {
    $shortSize = strtoupper(trim($_POST['size']));
    $_SESSION['size'] = $sizeMap[$shortSize] ?? 'small';
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

require_once 'db.php';

$sql = "SELECT skin_tone, gender FROM body_metrics WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$skin_tone = 'light';
$gender = 'male';

if ($row = $result->fetch_assoc()) {
    $skin_tone = $row['skin_tone'] ?: $skin_tone;
    $gender = $row['gender'] ?: $gender;
}

$stmt->close();
$conn->close();

$size = $_SESSION['size'] ?? 'small';
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 1;

switch ($product_id) {
    case 1:
    case 4:
        $pants = 'blackpants';
        $shirt = 'whiteshirt';
        break;
    case 2:
    case 3:
        $pants = 'bluepants';
        $shirt = 'blackshirt';
        break;
    default:
        $pants = 'blackpants';
        $shirt = 'whiteshirt';
}

$allowed_skins = ['light', 'dark'];
$allowed_genders = ['male', 'female'];
$allowed_sizes = ['small', 'medium', 'large', 'xlarge'];
$allowed_pants = ['blackpants', 'bluepants'];
$allowed_shirts = ['whiteshirt', 'blackshirt'];

if (!in_array($skin_tone, $allowed_skins)) $skin_tone = 'light';
if (!in_array($gender, $allowed_genders)) $gender = 'male';
if (!in_array($size, $allowed_sizes)) $size = 'small';
if (!in_array($pants, $allowed_pants)) $pants = 'blackpants';
if (!in_array($shirt, $allowed_shirts)) $shirt = 'whiteshirt';

$model_filename = "{$skin_tone}_{$gender}_{$size}_{$pants}_{$shirt}.glb";
$model_path = "models/{$model_filename}";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>3D Model Viewer</title>
  <style>
    body { margin: 0; overflow: hidden; }
    canvas { display: block; }
    #modelSelector {
      position: absolute;
      top: 10px;
      left: 10px;
      z-index: 10;
      font-size: 16px;
      padding: 5px;
    }
    .cta-section {
  text-align: center;
  margin-top: 0px;
  background-color: #145750;

}

.cta-button {
  background-color: #ffffff;
  position: relative;
  color: #418078;
  padding: 15px 30px;
  font-weight: 600;
  border-radius: 30px;
  text-decoration: none;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  transition: all 0.3s ease;
}

.cta-button:hover {
  background-color: #2f5f5a;
  color: #ffffff;
}

@media (max-width: 768px) {
  .cta-button {
    padding: 12px 25px;
    font-size: 14px;
  }
}
.divv {
  position: relative;
  top: 20px;
}
  </style>
</head>
<body>
        <section class="cta-section">
      <div class="divv"><a href="shop.php" class="cta-button">Shop More Products</a></div>
    </section>
  <select id="modelSelector"></select>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/dat.gui/build/dat.gui.min.js"></script>

  <script>
    let scene, camera, renderer, model = null;
    let controls, gui, directionalLight;

    const initialModel = "<?php echo $model_path; ?>";

    const skinTones = ['light', 'dark'];
    const genders = ['male', 'female'];
    const sizes = ['small', 'medium', 'large', 'xlarge'];
    const pantsList = ['blackpants', 'bluepants'];
    const shirtsList = ['whiteshirt', 'blackshirt'];

    const selector = document.getElementById("modelSelector");

    function generateFilenames() {
      const filenames = [];
      for (let skin of skinTones) {
        for (let gender of genders) {
          for (let size of sizes) {
            for (let pants of pantsList) {
              for (let shirt of shirtsList) {
                filenames.push(`${skin}_${gender}_${size}_${pants}_${shirt}.glb`);
              }
            }
          }
        }
      }
      return filenames;
    }

    function populateSelector() {
      const filenames = generateFilenames();
      filenames.forEach(name => {
        const option = document.createElement("option");
        option.value = "models/" + name;
        option.text = name;
        selector.appendChild(option);
      });

      // Preselect the currently loaded model
      selector.value = initialModel;
    }

    selector.addEventListener("change", function () {
      loadModel(this.value);
    });

    function loadModel(modelPath) {
      const loader = new THREE.GLTFLoader();
      loader.load(modelPath, function (gltf) {
        if (model) {
          scene.remove(model);
          model.traverse(child => {
            if (child.geometry) child.geometry.dispose();
            if (child.material) {
              if (Array.isArray(child.material)) {
                child.material.forEach(mat => mat.dispose());
              } else {
                child.material.dispose();
              }
            }
          });
        }

        model = gltf.scene;
        const bbox = new THREE.Box3().setFromObject(model);
        const boxMin = bbox.min;
        model.position.y -= boxMin.y;
        scene.add(model);
      }, undefined, function (error) {
        console.error("Error loading model:", error);
      });
    }

    function init() {
      scene = new THREE.Scene();
      scene.background = new THREE.Color(0x145750);

      camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 1000);
      camera.position.set(0, 1.6, 3);

      renderer = new THREE.WebGLRenderer({ antialias: true });
      renderer.setSize(window.innerWidth, window.innerHeight);
      document.body.appendChild(renderer.domElement);

      controls = new THREE.OrbitControls(camera, renderer.domElement);
      controls.target.set(0, 1, 0);
      controls.update();
      controls.enableRotate = false;
      controls.enablePan = false;
      controls.enableZoom = false;
      controls.enabled = false;  // disables all mouse interaction

      const planeGeometry = new THREE.PlaneGeometry(10, 10);
      const planeMaterial = new THREE.MeshStandardMaterial({ color: 0x1E5B53, depthWrite: false });
      const ground = new THREE.Mesh(planeGeometry, planeMaterial);
      ground.rotation.x = -Math.PI / 2;
      ground.position.y = 0;
      ground.renderOrder = -1;
      scene.add(ground);

      directionalLight = new THREE.DirectionalLight(0xffffff, 1);
      directionalLight.position.set(0, 10, 10);
      scene.add(directionalLight);

      const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
      scene.add(ambientLight);

      loadModel(initialModel);

      gui = new dat.GUI();
      const modelFolder = gui.addFolder("Model");
      const modelControls = { rotationY: 0 };
      modelFolder.add(modelControls, "rotationY", -Math.PI, Math.PI).step(0.0001).onChange(value => {
        if (model) model.rotation.y = value;
      });
      modelFolder.open();
//This Project is made collectively by Arham Ahmed & Hassan Afzal. We are students of 'The University of Faisalabad' and our batch is 2021-2025 (BSCS). Hassan has made the entire front-end design and helped with a the backend integration of cart, checkout page and Admin panel. Arham has contributed to the entire backend and 3D model implementation for this website. Our third member, Ayesha Shakeel has integrated Stripe Payment API via an external member, thus we have decided to not include it in this version. Anyone reading this can reach Arham Ahmed on "arhamahmed8699@gmail.com" and Hassan Afzal on "hassanafzal2701@gmail.com". Regards ~ arham ahmed
      const lightFolder = gui.addFolder("Lighting");
      const lightControls = {
        intensity: directionalLight.intensity,
        color: directionalLight.color.getHex()
      };
      lightFolder.add(lightControls, "intensity", 0, 2).step(0.01).onChange(value => {
        directionalLight.intensity = value;
      });
      lightFolder.addColor(lightControls, "color").onChange(value => {
        directionalLight.color.set(value);
      });
      lightFolder.open();

      window.addEventListener("resize", onWindowResize, false);
    }

    function onWindowResize() {
      camera.aspect = window.innerWidth / window.innerHeight;
      camera.updateProjectionMatrix();
      renderer.setSize(window.innerWidth, window.innerHeight);
    }

    function animate() {
      requestAnimationFrame(animate);
      renderer.render(scene, camera);
    }

    populateSelector();
    init();
    animate();
  </script>

</body>
</html>
