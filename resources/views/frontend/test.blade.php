<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz API Documentation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .header h1 {
            color: #2d3748;
            font-size: 2.5rem;
            margin-bottom: 10px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .header p {
            color: #666;
            font-size: 1.1rem;
        }
        
        .nav {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .nav h3 {
            margin-bottom: 15px;
            color: #2d3748;
        }
        
        .nav ul {
            list-style: none;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
        }
        
        .nav a {
            color: #667eea;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: block;
        }
        
        .nav a:hover {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            transform: translateY(-2px);
        }
        
        .section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .section h2 {
            color: #2d3748;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
            margin-bottom: 25px;
            font-size: 1.8rem;
        }
        
        .endpoint {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            transition: all 0.3s ease;
        }
        
        .endpoint:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        
        .method {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 0.8rem;
            margin-right: 10px;
            color: white;
        }
        
        .get { background: #10b981; }
        .post { background: #3b82f6; }
        .put { background: #f59e0b; }
        .delete { background: #ef4444; }
        
        .endpoint-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 15px;
        }
        
        .endpoint-url {
            background: #2d3748;
            color: #10b981;
            padding: 12px 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            margin: 15px 0;
            font-weight: 500;
        }
        
        .params, .response {
            margin-top: 20px;
        }
        
        .params h4, .response h4 {
            color: #4a5568;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }
        
        .param-item, .response-item {
            background: #edf2f7;
            border-left: 4px solid #667eea;
            padding: 12px 15px;
            margin-bottom: 10px;
            border-radius: 0 8px 8px 0;
        }
        
        .param-name, .response-field {
            font-weight: bold;
            color: #2d3748;
        }
        
        .param-type {
            color: #667eea;
            font-style: italic;
            margin-left: 10px;
        }
        
        .required {
            color: #e53e3e;
            font-size: 0.8rem;
            margin-left: 5px;
        }
        
        .auth-note {
            background: linear-gradient(45deg, #fef5e7, #fed7d7);
            border: 2px solid #f6ad55;
            border-radius: 10px;
            padding: 15px;
            margin: 20px 0;
        }
        
        .auth-note strong {
            color: #c53030;
        }
        
        pre {
            background: #2d3748;
            color: #e2e8f0;
            padding: 20px;
            border-radius: 8px;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            line-height: 1.4;
        }
        
        .example {
            margin-top: 15px;
        }
        
        .status-code {
            display: inline-block;
            background: #48bb78;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            margin-right: 10px;
        }
        
        .error-code {
            background: #f56565;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .nav ul {
                grid-template-columns: 1fr;
            }
            
            .section {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 Quiz API Documentation</h1>
            <p>Complete guide for Quiz Management System API endpoints</p>
        </div>

        <div class="nav">
            <h3>📋 Quick Navigation</h3>
            <ul>
                <li><a href="#authentication">🔐 Authentication</a></li>
                <li><a href="#admin-users">👥 Admin - Users</a></li>
                <li><a href="#admin-sections">📁 Admin - Sections</a></li>
                <li><a href="#admin-questions">❓ Admin - Questions</a></li>
                <li><a href="#student-endpoints">🎓 Student Endpoints</a></li>
                <li><a href="#public-endpoints">🌐 Public Endpoints</a></li>
            </ul>
        </div>

        <!-- Authentication Section -->
        <div class="section" id="authentication">
            <h2>🔐 Authentication</h2>
            
            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method post">POST</span>
                    Login
                </div>
                <div class="endpoint-url">POST /api/login</div>
                <p>Authenticate user and get access token</p>
                
                <div class="params">
                    <h4>📝 Request Body:</h4>
                    <div class="param-item">
                        <span class="param-name">email</span>
                        <span class="param-type">string</span>
                        <span class="required">*required</span>
                        <div>User's email address</div>
                    </div>
                    <div class="param-item">
                        <span class="param-name">password</span>
                        <span class="param-type">string</span>
                        <span class="required">*required</span>
                        <div>User's password</div>
                    </div>
                </div>
                
                <div class="response">
                    <h4>📤 Response:</h4>
                    <div class="example">
                        <span class="status-code">200</span>Success
                        <pre>{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "roles": ["student"],
    "permissions": []
  }
}</pre>
                    </div>
                </div>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method post">POST</span>
                    Register
                </div>
                <div class="endpoint-url">POST /api/register</div>
                <p>Create new user account</p>
                
                <div class="params">
                    <h4>📝 Request Body:</h4>
                    <div class="param-item">
                        <span class="param-name">name</span>
                        <span class="param-type">string</span>
                        <span class="required">*required</span>
                        <div>User's full name (max: 255)</div>
                    </div>
                    <div class="param-item">
                        <span class="param-name">email</span>
                        <span class="param-type">string</span>
                        <span class="required">*required</span>
                        <div>Unique email address</div>
                    </div>
                    <div class="param-item">
                        <span class="param-name">password</span>
                        <span class="param-type">string</span>
                        <span class="required">*required</span>
                        <div>Password (min: 6 characters)</div>
                    </div>
                </div>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method post">POST</span>
                    Logout
                </div>
                <div class="endpoint-url">POST /api/logout</div>
                <div class="auth-note">
                    <strong>🔒 Required Roles:</strong> super-admin | admin
                </div>
                <p>Get system statistics (users, tests, questions, answers count)</p>
                
                <div class="response">
                    <h4>📤 Response:</h4>
                    <div class="example">
                        <pre>{
  "users": 150,
  "tests": 25,
  "questions": 500,
  "answers": 2000
}</pre>
                    </div>
                </div>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method post">POST</span>
                    Import Questions
                </div>
                <div class="endpoint-url">POST /api/import/questions</div>
                <div class="auth-note">
                    <strong>🔒 Required Roles:</strong> super-admin | admin
                </div>
                <p>Import questions from CSV/Excel file</p>
                
                <div class="params">
                    <h4>📝 Request Body (Form Data):</h4>
                    <div class="param-item">
                        <span class="param-name">file</span>
                        <span class="param-type">file</span>
                        <span class="required">*required</span>
                        <div>CSV or XLSX file (max: 2MB)</div>
                    </div>
                </div>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method get">GET</span>
                    Get User Profile
                </div>
                <div class="endpoint-url">GET /api/profile</div>
                <div class="auth-note">
                    <strong>🔒 Authentication Required:</strong> Bearer Token
                </div>
                <p>Get current user's profile information</p>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method patch">PATCH</span>
                    Update Profile
                </div>
                <div class="endpoint-url">PATCH /api/profile</div>
                <div class="auth-note">
                    <strong>🔒 Authentication Required:</strong> Bearer Token
                </div>
                <p>Update current user's profile</p>
                
                <div class="params">
                    <h4>📝 Request Body:</h4>
                    <div class="param-item">
                        <span class="param-name">name</span>
                        <span class="param-type">string</span>
                        <div>User's name</div>
                    </div>
                    <div class="param-item">
                        <span class="param-name">email</span>
                        <span class="param-type">string</span>
                        <div>User's email</div>
                    </div>
                </div>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method delete">DELETE</span>
                    Delete Profile
                </div>
                <div class="endpoint-url">DELETE /api/profile</div>
                <div class="auth-note">
                    <strong>🔒 Authentication Required:</strong> Bearer Token
                </div>
                <p>Delete current user's account</p>
                
                <div class="params">
                    <h4>📝 Request Body:</h4>
                    <div class="param-item">
                        <span class="param-name">password</span>
                        <span class="param-type">string</span>
                        <span class="required">*required</span>
                        <div>Current password for confirmation</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error Codes Section -->
        <div class="section">
            <h2>⚠️ Common Error Responses</h2>
            
            <div class="endpoint">
                <div class="endpoint-title">HTTP Status Codes</div>
                
                <div class="response-item">
                    <span class="status-code">200</span>
                    <span class="response-field">OK</span> - Request successful
                </div>
                
                <div class="response-item">
                    <span class="status-code">201</span>
                    <span class="response-field">Created</span> - Resource created successfully
                </div>
                
                <div class="response-item">
                    <span class="status-code error-code">400</span>
                    <span class="response-field">Bad Request</span> - Invalid request format
                </div>
                
                <div class="response-item">
                    <span class="status-code error-code">401</span>
                    <span class="response-field">Unauthorized</span> - Authentication required
                </div>
                
                <div class="response-item">
                    <span class="status-code error-code">403</span>
                    <span class="response-field">Forbidden</span> - Insufficient permissions
                </div>
                
                <div class="response-item">
                    <span class="status-code error-code">404</span>
                    <span class="response-field">Not Found</span> - Resource not found
                </div>
                
                <div class="response-item">
                    <span class="status-code error-code">422</span>
                    <span class="response-field">Unprocessable Entity</span> - Validation errors
                </div>
                
                <div class="response-item">
                    <span class="status-code error-code">500</span>
                    <span class="response-field">Internal Server Error</span> - Server error
                </div>
                
                <div class="example">
                    <h4>Example Error Response:</h4>
                    <pre>{
  "message": "The given data was invalid.",
  "errors": {
    "email": [
      "The email field is required."
    ],
    "password": [
      "The password must be at least 6 characters."
    ]
  }
}</pre>
                </div>
            </div>
        </div>

        <!-- Authentication Guide Section -->
        <div class="section">
            <h2>🔑 Authentication Guide</h2>
            
            <div class="endpoint">
                <div class="endpoint-title">How to use Bearer Token</div>
                <p>After successful login, include the token in all authenticated requests:</p>
                
                <div class="example">
                    <h4>JavaScript Example:</h4>
                    <pre>// Store token after login
const token = response.data.token;
localStorage.setItem('auth_token', token);

// Use token in subsequent requests
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

// Or per request
const config = {
  headers: {
    'Authorization': `Bearer ${token}`
  }
};

const response = await axios.get('/api/student/display', config);</pre>
                </div>
                
                <div class="example">
                    <h4>cURL Example:</h4>
                    <pre>curl -X GET \
  'https://yourapi.com/api/student/display' \
  -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...' \
  -H 'Accept: application/json'</pre>
                </div>
            </div>
        </div>

        <!-- Usage Examples Section -->
        <div class="section">
            <h2>💡 Usage Examples</h2>
            
            <div class="endpoint">
                <div class="endpoint-title">Complete Student Quiz Flow</div>
                
                <div class="example">
                    <pre>// 1. Login
const loginResponse = await axios.post('/api/login', {
  email: 'student@example.com',
  password: 'password123'
});

const token = loginResponse.data.token;
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

// 2. Get available tests
const testsResponse = await axios.get('/api/student/display');
const tests = testsResponse.data.data;

// 3. Get questions for a specific test
const testId = tests[0].id;
const questionsResponse = await axios.get(`/api/student/question/${testId}`);
const questions = questionsResponse.data.data;

// 4. Submit answers
for (const question of questions) {
  const selectedAnswer = question.answers[0]; // User's choice
  await axios.post('/api/student/submit-answer', {
    question_id: question.id,
    answer_id: selectedAnswer.id
  });
}

// 5. Get final results
const resultResponse = await axios.get(`/api/student/final-result/${testId}`);
const finalScore = resultResponse.data;</pre>
                </div>
            </div>
            
            <div class="endpoint">
                <div class="endpoint-title">Admin Question Management</div>
                
                <div class="example">
                    <pre>// 1. Login as admin
const adminLogin = await axios.post('/api/login', {
  email: 'admin@example.com',
  password: 'adminpass'
});

const token = adminLogin.data.token;
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

// 2. Create a new section
const sectionResponse = await axios.post('/api/admin/section', {
  title: 'Science Quiz',
  description: 'Basic science questions',
  duration: 45
});

const sectionId = sectionResponse.data.id;

// 3. Add questions to the section
const questionData = {
  question_text: 'What is the chemical symbol for water?',
  test_id: sectionId,
  answers: [
    { answer_text: 'H2O', is_correct: true },
    { answer_text: 'CO2', is_correct: false },
    { answer_text: 'O2', is_correct: false },
    { answer_text: 'NaCl', is_correct: false }
  ]
};

await axios.post('/api/admin/questions', questionData);

// 4. Get all questions for review
const questionsResponse = await axios.get('/api/admin/questions', {
  params: { test_id: sectionId }
});</pre>
                </div>
            </div>
        </div>

        <!-- Rate Limiting Section -->
        <div class="section">
            <h2>🚦 Rate Limiting & Best Practices</h2>
            
            <div class="endpoint">
                <div class="endpoint-title">General Guidelines</div>
                
                <div class="param-item">
                    <span class="param-name">Rate Limits</span>
                    <div>• Authentication endpoints: 5 requests per minute</div>
                    <div>• General API: 60 requests per minute per user</div>
                    <div>• File uploads: 3 requests per minute</div>
                </div>
                
                <div class="param-item">
                    <span class="param-name">Content-Type</span>
                    <div>• Use <code>application/json</code> for JSON requests</div>
                    <div>• Use <code>multipart/form-data</code> for file uploads</div>
                </div>
                
                <div class="param-item">
                    <span class="param-name">Headers</span>
                    <div>• Always include <code>Accept: application/json</code></div>
                    <div>• Include <code>Authorization: Bearer {token}</code> for protected routes</div>
                </div>
                
                <div class="param-item">
                    <span class="param-name">Error Handling</span>
                    <div>• Always check response status codes</div>
                    <div>• Handle validation errors from 422 responses</div>
                    <div>• Implement retry logic for 5xx errors</div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="section">
            <h2>📞 Support & Resources</h2>
            
            <div class="endpoint">
                <div class="endpoint-title">Need Help?</div>
                <p>If you encounter any issues or need assistance:</p>
                
                <div class="param-item">
                    <span class="param-name">📧 Technical Support</span>
                    <div>Email: support@yourapp.com</div>
                </div>
                
                <div class="param-item">
                    <span class="param-name">📚 Documentation</span>
                    <div>Visit our developer portal for more resources</div>
                </div>
                
                <div class="param-item">
                    <span class="param-name">🐛 Bug Reports</span>
                    <div>Report issues through our bug tracking system</div>
                </div>
                
                <div class="param-item">
                    <span class="param-name">🔄 API Version</span>
                    <div>Current Version: v1.0</div>
                    <div>Last Updated: January 2024</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add copy functionality to code blocks
        document.querySelectorAll('pre').forEach(pre => {
            pre.style.position = 'relative';
            pre.style.cursor = 'pointer';
            pre.title = 'Click to copy';
            
            pre.addEventListener('click', async () => {
                try {
                    await navigator.clipboard.writeText(pre.textContent);
                    
                    // Show feedback
                    const originalBg = pre.style.backgroundColor;
                    pre.style.backgroundColor = '#4ade80';
                    pre.style.transition = 'background-color 0.3s ease';
                    
                    setTimeout(() => {
                        pre.style.backgroundColor = originalBg;
                    }, 300);
                    
                } catch (err) {
                    console.error('Failed to copy text: ', err);
                }
            });
        });
    </script>
</body>
</html><strong>🔒 Authentication Required:</strong> Bearer Token
                </div>
                <p>Logout and invalidate current token</p>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method get">GET</span>
                    Check Authentication
                </div>
                <div class="endpoint-url">GET /api/check-auth</div>
                <div class="auth-note">
                    <strong>🔒 Authentication Required:</strong> Bearer Token
                </div>
                <p>Get current user information</p>
            </div>
        </div>

        <!-- Admin Users Section -->
        <div class="section" id="admin-users">
            <h2>👥 Admin - User Management</h2>
            <div class="auth-note">
                <strong>🔒 Required Roles:</strong> super-admin | admin
            </div>
            
            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method get">GET</span>
                    Get All Users
                </div>
                <div class="endpoint-url">GET /api/admin/users</div>
                <p>Retrieve all users with their roles</p>
                
                <div class="response">
                    <h4>📤 Response:</h4>
                    <div class="example">
                        <pre>{
  "data": [
    {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "roles": [{"name": "student"}]
    }
  ]
}</pre>
                    </div>
                </div>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method post">POST</span>
                    Create User
                </div>
                <div class="endpoint-url">POST /api/admin/users</div>
                
                <div class="params">
                    <h4>📝 Request Body:</h4>
                    <div class="param-item">
                        <span class="param-name">name</span>
                        <span class="param-type">string</span>
                        <span class="required">*required</span>
                    </div>
                    <div class="param-item">
                        <span class="param-name">email</span>
                        <span class="param-type">string</span>
                        <span class="required">*required</span>
                    </div>
                    <div class="param-item">
                        <span class="param-name">password</span>
                        <span class="param-type">string</span>
                        <span class="required">*required</span>
                    </div>
                    <div class="param-item">
                        <span class="param-name">role</span>
                        <span class="param-type">string</span>
                        <span class="required">*required</span>
                    </div>
                </div>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method post">POST</span>
                    Update User Role
                </div>
                <div class="endpoint-url">POST /api/admin/users/{userId}/update-role</div>
                
                <div class="params">
                    <h4>📝 Request Body:</h4>
                    <div class="param-item">
                        <span class="param-name">role</span>
                        <span class="param-type">string</span>
                        <span class="required">*required</span>
                    </div>
                </div>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method delete">DELETE</span>
                    Delete User
                </div>
                <div class="endpoint-url">DELETE /api/admin/users/{userId}</div>
                <p>Permanently delete a user</p>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method get">GET</span>
                    Get Available Roles
                </div>
                <div class="endpoint-url">GET /api/admin/roles</div>
                <p>Get list of all available roles</p>
            </div>
        </div>

        <!-- Admin Sections Section -->
        <div class="section" id="admin-sections">
            <h2>📁 Admin - Sections Management</h2>
            <div class="auth-note">
                <strong>🔒 Required Roles:</strong> super-admin | admin
            </div>
            
            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method get">GET</span>
                    Get All Sections
                </div>
                <div class="endpoint-url">GET /api/admin/section</div>
                <p>Retrieve all test sections</p>
                
                <div class="response">
                    <h4>📤 Response:</h4>
                    <div class="example">
                        <pre>[
  {
    "id": "uuid-string",
    "title": "Math Test",
    "description": "Basic math questions",
    "duration": 30,
    "questions_count": 10,
    "created_at": "2024-01-01T00:00:00.000000Z"
  }
]</pre>
                    </div>
                </div>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method post">POST</span>
                    Create Section
                </div>
                <div class="endpoint-url">POST /api/admin/section</div>
                
                <div class="params">
                    <h4>📝 Request Body:</h4>
                    <div class="param-item">
                        <span class="param-name">title</span>
                        <span class="param-type">string</span>
                        <span class="required">*required</span>
                        <div>Section title (max: 255)</div>
                    </div>
                    <div class="param-item">
                        <span class="param-name">description</span>
                        <span class="param-type">string</span>
                        <div>Optional description</div>
                    </div>
                    <div class="param-item">
                        <span class="param-name">duration</span>
                        <span class="param-type">integer</span>
                        <span class="required">*required</span>
                        <div>Test duration in minutes (min: 1)</div>
                    </div>
                </div>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method put">PUT</span>
                    Update Section
                </div>
                <div class="endpoint-url">PUT /api/admin/section/{sectionId}</div>
                <p>Update existing section</p>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method delete">DELETE</span>
                    Delete Section
                </div>
                <div class="endpoint-url">DELETE /api/admin/section/{sectionId}</div>
                <p>Delete section and all related questions</p>
            </div>
        </div>

        <!-- Admin Questions Section -->
        <div class="section" id="admin-questions">
            <h2>❓ Admin - Questions Management</h2>
            <div class="auth-note">
                <strong>🔒 Required Roles:</strong> super-admin | admin
            </div>
            
            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method get">GET</span>
                    Get Questions
                </div>
                <div class="endpoint-url">GET /api/admin/questions</div>
                <p>Get paginated questions with optional filtering</p>
                
                <div class="params">
                    <h4>🔍 Query Parameters:</h4>
                    <div class="param-item">
                        <span class="param-name">test_id</span>
                        <span class="param-type">string</span>
                        <div>Filter by specific test ID</div>
                    </div>
                    <div class="param-item">
                        <span class="param-name">page</span>
                        <span class="param-type">integer</span>
                        <div>Page number for pagination</div>
                    </div>
                </div>
                
                <div class="response">
                    <h4>📤 Response:</h4>
                    <div class="example">
                        <pre>{
  "data": [
    {
      "id": "uuid-string",
      "question_text": "What is 2+2?",
      "test_id": "test-uuid",
      "test": {"title": "Math Test"},
      "answers": [
        {
          "id": "answer-uuid",
          "answer_text": "4",
          "is_correct": true
        }
      ]
    }
  ],
  "current_page": 1,
  "last_page": 5,
  "total": 50
}</pre>
                    </div>
                </div>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method post">POST</span>
                    Create Question
                </div>
                <div class="endpoint-url">POST /api/admin/questions</div>
                
                <div class="params">
                    <h4>📝 Request Body:</h4>
                    <div class="param-item">
                        <span class="param-name">question_text</span>
                        <span class="param-type">string</span>
                        <span class="required">*required</span>
                        <div>Question text (max: 1000)</div>
                    </div>
                    <div class="param-item">
                        <span class="param-name">test_id</span>
                        <span class="param-type">string</span>
                        <span class="required">*required</span>
                        <div>Valid test ID</div>
                    </div>
                    <div class="param-item">
                        <span class="param-name">answers</span>
                        <span class="param-type">array</span>
                        <span class="required">*required</span>
                        <div>Array of answer objects (min: 2)</div>
                    </div>
                    <div class="param-item">
                        <span class="param-name">answers.*.answer_text</span>
                        <span class="param-type">string</span>
                        <span class="required">*required</span>
                        <div>Answer text (max: 500)</div>
                    </div>
                    <div class="param-item">
                        <span class="param-name">answers.*.is_correct</span>
                        <span class="param-type">boolean</span>
                        <div>Mark if this answer is correct</div>
                    </div>
                </div>
                
                <div class="example">
                    <h4>📝 Example Request:</h4>
                    <pre>{
  "question_text": "What is the capital of France?",
  "test_id": "test-uuid-here",
  "answers": [
    {
      "answer_text": "Paris",
      "is_correct": true
    },
    {
      "answer_text": "London",
      "is_correct": false
    },
    {
      "answer_text": "Berlin",
      "is_correct": false
    }
  ]
}</pre>
                </div>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method put">PUT</span>
                    Update Question
                </div>
                <div class="endpoint-url">PUT /api/admin/questions/{questionId}</div>
                <p>Update existing question and its answers</p>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method delete">DELETE</span>
                    Delete Question
                </div>
                <div class="endpoint-url">DELETE /api/admin/questions/{questionId}</div>
                <p>Delete specific question and its answers</p>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method delete">DELETE</span>
                    Delete All Questions
                </div>
                <div class="endpoint-url">DELETE /api/admin/questions</div>
                <p>⚠️ Danger: Delete all questions in the system</p>
            </div>
        </div>

        <!-- Student Endpoints Section -->
        <div class="section" id="student-endpoints">
            <h2>🎓 Student Endpoints</h2>
            <div class="auth-note">
                <strong>🔒 Required Roles:</strong> student | super-admin
            </div>
            
            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method get">GET</span>
                    Get Available Tests
                </div>
                <div class="endpoint-url">GET /api/student/display</div>
                <p>Get tests available for students to take</p>
                
                <div class="response">
                    <h4>📤 Response:</h4>
                    <div class="example">
                        <pre>{
  "data": [
    {
      "id": "uuid-string",
      "title": "Math Quiz",
      "description": "Basic mathematics",
      "duration": 30,
      "questions_count": 15
    }
  ]
}</pre>
                    </div>
                </div>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method get">GET</span>
                    Get Test Questions
                </div>
                <div class="endpoint-url">GET /api/student/question/{testId}</div>
                <p>Get all questions for a specific test</p>
                
                <div class="response">
                    <h4>📤 Response:</h4>
                    <div class="example">
                        <pre>{
  "data": [
    {
      "id": "question-uuid",
      "question_text": "What is 2+2?",
      "test_id": "test-uuid",
      "answers": [
        {
          "id": "answer-uuid-1",
          "answer_text": "3",
          "is_correct": false
        },
        {
          "id": "answer-uuid-2", 
          "answer_text": "4",
          "is_correct": true
        }
      ]
    }
  ]
}</pre>
                    </div>
                </div>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method post">POST</span>
                    Submit Answer
                </div>
                <div class="endpoint-url">POST /api/student/submit-answer</div>
                <p>Submit student's answer for a question</p>
                
                <div class="params">
                    <h4>📝 Request Body:</h4>
                    <div class="param-item">
                        <span class="param-name">question_id</span>
                        <span class="param-type">string (UUID)</span>
                        <span class="required">*required</span>
                        <div>Valid question ID</div>
                    </div>
                    <div class="param-item">
                        <span class="param-name">answer_id</span>
                        <span class="param-type">string (UUID)</span>
                        <span class="required">*required</span>
                        <div>Valid answer ID for the question</div>
                    </div>
                </div>
                
                <div class="response">
                    <h4>📤 Response:</h4>
                    <div class="example">
                        <pre>{
  "message": "Answer saved successfully.",
  "correct": true
}</pre>
                    </div>
                </div>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method get">GET</span>
                    Get User Answers
                </div>
                <div class="endpoint-url">GET /api/student/user-answers</div>
                <p>Get all answers submitted by the current user</p>
                
                <div class="response">
                    <h4>📤 Response:</h4>
                    <div class="example">
                        <pre>{
  "question-uuid-1": "answer-uuid-1",
  "question-uuid-2": "answer-uuid-2"
}</pre>
                    </div>
                </div>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method get">GET</span>
                    Get Final Result
                </div>
                <div class="endpoint-url">GET /api/student/final-result/{testId}</div>
                <p>Get final test results for a specific test</p>
                
                <div class="response">
                    <h4>📤 Response:</h4>
                    <div class="example">
                        <pre>{
  "correct": 8,
  "total": 10,
  "score": 80
}</pre>
                    </div>
                </div>
            </div>

            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method post">POST</span>
                    Clear Answers
                </div>
                <div class="endpoint-url">POST /api/student/clear-answers</div>
                <p>Clear all submitted answers for the current user</p>
            </div>
        </div>

        <!-- Public Endpoints Section -->
        <div class="section" id="public-endpoints">
            <h2>🌐 Other Endpoints</h2>
            
            <div class="endpoint">
                <div class="endpoint-title">
                    <span class="method get">GET</span>
                    Get Statistics
                </div>
                <div class="endpoint-url">GET /api/admin/stats</div>
                <div class="auth-note">
                    <strong>🔒 Authentication Required:</strong> Bear token </div>
                <p>Get system statistics including user counts and test statistics</p>
            </div>
        </div>
    </div>
</body>
</html>